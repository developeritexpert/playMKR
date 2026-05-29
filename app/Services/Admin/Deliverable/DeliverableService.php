<?php


namespace App\Services\Admin\Deliverable;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Helpers\ApiResponse;
use App\Helpers\FileUploadHelper;
use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use App\Repositories\Contracts\DeliverableRepositoryInterface;

class DeliverableService
{
    protected DeliverableRepositoryInterface $deliverableRepo;

    public function __construct(DeliverableRepositoryInterface $deliverableRepo){
        $this->deliverableRepo =  $deliverableRepo;
    }

    public function getAll(array $filters = [], $perPage = 10)
    {
        try {
            $deliverables = $this->deliverableRepo->paginate($filters, $perPage);
            return ApiResponse::success($deliverables, ApiMessages::DELIVERABLES_FETCHED);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessages::ERROR, StatusCodes::SERVER_ERROR, $e->getMessage());
        }
    }

    public function getById(int $id){
        try {
            $deliverable = $this->deliverableRepo->find($id);
            if (!$deliverable) {
                return ApiResponse::error(
                    ApiMessages::DELIVERABLE_NOT_FOUND,
                    StatusCodes::NOT_FOUND
                );
            }
            return ApiResponse::success($deliverable,
                ApiMessages::DELIVERABLE_FETCHED
            );

        } catch (Exception $e) {
            return ApiResponse::error(
                ApiMessages::ERROR,
                StatusCodes::SERVER_ERROR,
                $e->getMessage()
            );
        }
    }


//     public function create(array $data){
//         DB::beginTransaction();
//        try {
//         if (!empty($data['deliver_type'])) {
//             $deliverType =
//                 $this->deliverableRepo
//                 ->createDeliverType(
//                     $data['deliver_type']
//                 );
//             $data['deliver_type_id'] =
//                 $deliverType->id;

//             unset($data['deliver_type']);
//         }

//         if (!empty($data['status'])) {

//             $data['status_updated_at'] =
//                 now();
//         }

//         $attachments =
//             request()->file('attachments', []);

//         unset($data['attachments']);

//         $deliverable =
//             $this->deliverableRepo
//             ->create($data);

//         if (!empty($attachments)) {
//             foreach ($attachments as $file) {
//                 if ($file->isValid()) {
//                     $path = FileUploadHelper::upload($file,'deliverables');

//                     $this->deliverableRepo
//                         ->createAttachment([
//                             'deliverable_id' =>$deliverable->id,
//                             'file_path' => $path,
//                         ]);
//                 }
//             }
//         }

//         DB::commit();

//         return ApiResponse::success(
//             $this->deliverableRepo->find($deliverable->id),
//             ApiMessages::DELIVERABLE_CREATED,
//             StatusCodes::CREATED
//         );

//         } catch (Exception $e) {
//             DB::rollBack();
//             return ApiResponse::error(
//                 ApiMessages::ERROR,
//                 StatusCodes::SERVER_ERROR,
//                 $e->getMessage()
//             );
//         }
// }

public function create(array $data){
    DB::beginTransaction();
    try {
        $lastDeliverable = $this->deliverableRepo->getLastDeliverable();
        if ($lastDeliverable && $lastDeliverable->task_id) {
            $lastNumber = (int) str_replace('T', '', $lastDeliverable->task_id);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1; 
        }
        
        $data['task_id'] = 'T' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        if (!empty($data['deliver_type'])) {
            $deliverType = $this->deliverableRepo->createDeliverType($data['deliver_type']);
            $data['deliver_type_id'] = $deliverType->id;

            unset($data['deliver_type']);
        }

        if (!empty($data['status'])) {
            $data['status_updated_at'] = now();
        }

        $attachments = request()->file('attachments', []);

        unset($data['attachments']);

        $deliverable = $this->deliverableRepo->create($data);

        if (!empty($attachments)) {
            foreach ($attachments as $file) {
                if ($file->isValid()) {
                    $path = FileUploadHelper::upload($file,'deliverables');

                    $this->deliverableRepo->createAttachment([
                        'deliverable_id' => $deliverable->id,
                        'file_path' => $path,
                    ]);
                }
            }
        }

        DB::commit();

        return ApiResponse::success(
            $this->deliverableRepo->find($deliverable->id),
            ApiMessages::DELIVERABLE_CREATED,
            StatusCodes::CREATED
        );

    } catch (Exception $e) {
        DB::rollBack();
        return ApiResponse::error(
            ApiMessages::ERROR,
            StatusCodes::SERVER_ERROR,
            $e->getMessage()
        );
    }
}


    public function update(int $id, array $data){
        DB::beginTransaction();
        try {
    
            $deliverable =$this->deliverableRepo->find($id);
            if (!$deliverable) {    
                return ApiResponse::error(
                    ApiMessages::DELIVERABLE_NOT_FOUND,
                    StatusCodes::NOT_FOUND
                );
            }
    
            if (
                isset($data['deliver_type']) &&
                !isset($data['deliver_type_id'])
            ) {

                $deliverType =$this->deliverableRepo->createDeliverType($data['deliver_type']);
                $data['deliver_type_id'] = $deliverType->id;
            }
    
            unset($data['deliver_type']);
            if (isset($data['status'])) {
                $data['status_updated_at'] = now();
            }
    
            $attachments =
                $data['attachments'] ?? [];
    
            unset($data['attachments']);
    
            $updatedDeliverable =
                $this->deliverableRepo
                ->update(
                    $deliverable,
                    $data
                );
    
            if (!empty($attachments)) {
    
                foreach ($attachments as $file) {
    
                    $path =
                        FileUploadHelper::upload(
                            $file,
                            'deliverables'
                        );
    
                    $this->deliverableRepo
                        ->createAttachment([
                            'deliverable_id' =>
                                $deliverable->id,
    
                            'file_path' => $path,
                        ]);
                }
            }
    
            DB::commit();
    
            return ApiResponse::success(
                $this->deliverableRepo
                    ->find($updatedDeliverable->id),
    
                ApiMessages::DELIVERABLE_UPDATED
            );
    
        } catch (Exception $e) {
    
            DB::rollBack();
    
            return ApiResponse::error(
                ApiMessages::ERROR,
                StatusCodes::SERVER_ERROR,
                $e->getMessage()
            );
        }
    }
    

    public function delete(int $id){
        try {
            $deliverable =$this->deliverableRepo->find($id);
            if (!$deliverable) {
                return ApiResponse::error(
                    ApiMessages::DELIVERABLE_NOT_FOUND,
                    StatusCodes::NOT_FOUND
                );
            }

            foreach (
                $deliverable->attachments as $attachment
            ) {
                FileUploadHelper::delete($attachment->file_path);
            }
            $this->deliverableRepo->delete($deliverable);
            return ApiResponse::success(null,
                ApiMessages::DELIVERABLE_DELETED
            );

        } catch (Exception $e) {
            return ApiResponse::error(
                ApiMessages::ERROR,
                StatusCodes::SERVER_ERROR,$e->getMessage()
            );
        }
    }
}