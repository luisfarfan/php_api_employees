<?php

/**
 * Created by PhpStorm.
 * User: lfarfan
 * Date: 25/02/2017
 * Time: 15:23
 */
require 'utils.php';

class ApiEmployes
{
    private $jsonEmployes;
    private $jsonEmployesArray;
    private $employesValues;
    private $response = [];

    function __construct()
    {
        $this->jsonEmployes = file_get_contents('../data/employees.json');
        $this->jsonEmployesArray = json_decode($this->jsonEmployes);
    }


    function getEmployes($id = null)
    {
        if ($id) {
            foreach ($this->jsonEmployesArray as $key => $value) {
                if ($value->id == $id) {
                    $this->response[] = $value;
                }
            }
        } else {
            $this->response = $this->jsonEmployesArray;
        }
        return json_encode($this->setValuesEmployes());
    }

    function getEmployesbyEmail($email)
    {
        foreach ($this->jsonEmployesArray as $key => $value) {
            if ($value->email == $email) {
                $this->response[] = $value;
            }
        }
        return json_encode($this->setValuesEmployes(['name', 'email', 'phone', 'address', 'position', 'salary', 'skills']));
    }

    function getEmployesSalaryRange($min, $max)
    {
        foreach ($this->jsonEmployesArray as $key => $value) {
            $float_salary = (float)str_replace(['$', ','], '', $value->salary);
            if ($float_salary >= $min && $float_salary <= $max) {
                $this->response[] = $value;
            }
        }
        $xml = json_to_xml(json_decode(json_encode($this->setValuesEmployes(['name',
            'email', 'phone', 'address', 'position', 'salary', 'skills'])), true));
        $xmlstr = <<<XML
            $xml
XML;
        return $xmlstr;
    }

    private function setValuesEmployes($values = ['name', 'email', 'position', 'salary'])
    {
        if (count($this->response) > 1) {
            foreach ($this->response as $key => $value) {
                $employee = [];
                foreach ($values as $k => $v) {
                    $employee[$v] = $value->$v;
                }
                $this->employesValues[] = (object)$employee;
            }
            $respuesta = $this->employesValues;
        } else if (count($this->response) === 1) {
            foreach ($values as $k => $v) {
                $employee[$v] = $this->response[0]->$v;
            }
            $this->employesValues = (object)$employee;
            $respuesta = $this->employesValues;
        } else if (count($this->response) === 0) {
            $respuesta = ['msj' => 'No existe'];
        }
        return $respuesta;
    }

}