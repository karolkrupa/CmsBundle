<?php

namespace Devster\CmsBundle\Crud\Edit;

class EditPageEvents
{
    const BEFORE_HANDLE_REQUEST = 'before_handle_request';
    const AFTER_HANDLE_REQUEST = 'after_handle_request';

    const BEFORE_FLUSH = 'before_flush';
    const AFTER_FLUSH = 'after_flush';

    const VALIDATION_ERROR = 'validation_error';
}