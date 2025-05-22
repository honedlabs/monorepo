<?php

namespace Honed\Table\Contracts;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

interface TableExporter extends FromQuery, WithHeadings, WithMapping
{
    //
}