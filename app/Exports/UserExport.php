<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Survey;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    public $data;
    public $firstName;
    public $email;
    public $lastName;

    public function __construct($data,$firstName,$lastName,$email)
    {
        $this->data = $data;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data;
    }

    
    /**
     * @return array
     */
    public function headings(): array{
        $heading = [];
        if($this->lastName == 'true'){
            array_push($heading,'Nom');
        }
        if($this->firstName == 'true'){
            array_push($heading,'Prénom');
        }
        if($this->email == 'true'){
            array_push($heading,'Email');
        }
        return $heading;
    }
    
}
