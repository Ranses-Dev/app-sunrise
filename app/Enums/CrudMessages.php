<?php

namespace App\Enums;

enum CrudMessages: string
{
    case CREATE_SUCCESS = 'Record created successfully.';
    case UPDATE_SUCCESS = 'Record updated successfully.';
    case DELETE_SUCCESS = 'Record deleted successfully.';
    case CREATE_FAILURE = 'Failed to create the record.';
    case UPDATE_FAILURE = 'Failed to update the record.';
    case DELETE_FAILURE = 'Failed to delete the record.';

}
