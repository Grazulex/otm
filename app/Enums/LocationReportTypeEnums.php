<?php

namespace App\Enums;

enum LocationReportTypeEnums: string
{
    case EMAIL = 'email';
    case API = 'api';
    case SFTP = 'sftp';
}
