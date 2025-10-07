<?php

namespace App\Enums;

/**
 * 
 * Enum of REST API action type
 *
 */
enum Rest_Api_Action_Type {
    /**
     * 
     * Adding element
     */
    case Add;
    /**
     * 
     * Updating element
     */
    case Edit;
    /**
     * 
     * Deleting element
     */
    case Delete;
}
