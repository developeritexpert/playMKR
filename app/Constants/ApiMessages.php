<?php

namespace App\Constants;

class ApiMessages
{
    const SUCCESS = 'Success';
    const ERROR = 'Error';

    //Auth Messages
    const USER_CREATED = 'User created successfully';
    const USER_NOT_FOUND = 'User not found';
    const SOMETHING_WENT_WRONG = 'Something went wrong';
    const VALIDATION_FAILED = 'Validation failed';
    const EMAIL_ALREADY_EXISTS = 'Email already exists';
    const INVALID_CREDENTIALS = 'Invalid credentials';
    const LOGIN_SUCCESS = 'Login successful';
    const UNAUTHORIZED = 'Unauthorized';
    const FORBIDDEN = 'Forbidden';
    const TOKEN_NOT_FOUND = 'Token not found';
    const TOKEN_REQUIRED = 'Token is required';
    const TOKEN_EXPIRED = 'Token has expired';
    const TOKEN_INVALID = 'Token is invalid';
    const AUTHENTICATION_FAILED = 'Authentication failed';
    const LOGOUT_SUCCESS = 'Logout successful';
    const PASSWORD_RESET_SUCCESS = 'Password reset successful';
    const RESET_TOKEN_SENT = 'Reset token sent to email';
    const INVALID_REQUEST = 'Invalid request';
    const PASSWORD_UPDATED = 'Password updated successfully';

    //API/SponsorController
    const SPONSORS_FETCHED = 'Sponsors fetched successfully';
    const SPONSOR_FETCHED = 'Sponsor fetched successfully';
    const SPONSOR_CREATED = 'Sponsor created successfully';
    const SPONSOR_UPDATED = 'Sponsor updated successfully';
    const SPONSOR_DELETED = 'Sponsor deleted successfully';
    const SPONSOR_NOT_FOUND = 'Sponsor not found';

    const DEALS_FETCHED = 'Deals fetched successfully';
    const DEAL_FETCHED = 'Deal fetched successfully';
    const DEAL_CREATED = 'Deal created successfully';
    const DEAL_UPDATED = 'Deal updated successfully';
    const DEAL_DELETED = 'Deal deleted successfully';
    const DEAL_NOT_FOUND = 'Deal not found';

    //Auth/Sponser Messages
    const SPONSER_REQUEST_SUCCESS = 'Your application has been submitted successfully , we will contact you soon!';
    const SPONSER_LIST_SUCCESS = 'Sponsor applications fetched successfully';

    const SPONSER_NOT_FOUND = 'Sponsor Not Found';
    const SPONSER_APPROVED = 'Sponsor Approved Successfully';
    const SPONSER_REJECTED = 'Sponser Rejected';

    const EMAIL_APPROVED = 'Email already approved';

    const DEAL_TYPES_FETCHED = "Deal types fetched successfully";
    const DEAL_TYPE_FETCHED = "Deal type fetched successfully";
    const DEAL_TYPE_CREATED = "Deal type created successfully";
    const DEAL_TYPE_UPDATED = "Deal type updated successfully";
    const DEAL_TYPE_DELETED = "Deal type deleted successfully";
    const DEAL_TYPE_NOT_FOUND = "Deal type not found";

    const DELIVERABLE_CREATED = 'Deliverable created successfully';
    const DELIVERABLE_UPDATED = 'Deliverable updated successfully';
    const DELIVERABLE_DELETED = 'Deliverable deleted successfully';
    const DELIVERABLE_FETCHED = 'Deliverable fetched successfully';
    const DELIVERABLES_FETCHED = 'Deliverables fetched successfully';
    const DELIVERABLE_NOT_FOUND = 'Deliverable not found';

    const DELIVER_TYPE_CREATED = 'Deliver type created successfully';
    const DELIVER_TYPE_UPDATED = 'Deliver type updated successfully';
    const DELIVER_TYPE_DELETED = 'Deliver type deleted successfully';
    const DELIVER_TYPE_LIST = 'Deliver type list fetched successfully';
    const DELIVER_TYPE_NOT_FOUND = 'Deliver type not found';

    const PROFILE_UPDATED = 'Profile updated successfully';
    const INVALID_CURRENT_PASSWORD = 'Current password is incorrect';

    // Internal Team 
    const INTERNAL_TEAM_CREATED = 'Internal team member created successfully';
    const INTERNAL_TEAM_FETCHED = 'Internal team members fetched successfully';
    const INTERNAL_TEAM_NOT_FOUND = 'Internal team member not found';
    const INTERNAL_TEAM_UPDATED = 'Internal team member updated successfully';
    const INTERNAL_TEAM_DELETED = 'Internal team member deleted successfully';
    const INTERNAL_TEAM_EMAIL_EXISTS = 'Email already exists';
}
