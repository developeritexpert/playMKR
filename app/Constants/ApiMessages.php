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

    //Sponser Messages
    const SPONSER_REQUEST_SUCCESS = 'Your application has been submitted successfully , we will contact you soon!';
}