<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\EmployeeModel;

class EmployeeController extends ResourceController
{
    private function setCorsHeaders()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Access-Control-Allow-Credentials: true');
    }

    public function listEmployees()
    {
        $this->setCorsHeaders();
        $employee = new EmployeeModel();

        $employees = $employee->findAll();

        if (!empty($employees)) {
            $res = [
                "status" => true,
                "message" => "employees",
                "data" => $employees
            ];
        } else {
            $res = [
                "status" => false,
                "message" => "no employees",
                "data" => []
            ];
        }

        return $this->respondCreated($res);
    }

    public function showEmployee($employeeId)
    {
        $this->setCorsHeaders();
        $employee = new EmployeeModel();
        $data = $employee->find($employeeId);

        if (!empty($data)) {
            $res = [
                "status" => true,
                "message" => "employee found",
                "data" => $data
            ];
        } else {
            $res = [
                "status" => false,
                "message" => "employee not found",
                "data" => []
            ];
        }

        return $this->respondCreated($res);
    }

    public function addEmployee()
    {
        $this->setCorsHeaders();
        $rules = array(
            "name" => "required",
            "email" => "required|valid_email|is_unique[employees.email]"
        );

        if (!$this->validate($rules)) {
            $res = [
                "status" => false,
                "message" => $this->validator->getErrors(),
                "data" => []
            ];
        } else {
            $fileImage = $this->request->getFile("profile_image");

            if (!empty($fileImage)) {
                $imageName = $fileImage->getName();
                $temp = explode(".", $imageName);
                // $newImageName = round(microtime((true)).end($temp));
                $newImageName = uniqid() . mt_rand() . "." . end($temp);

                if ($fileImage->move("images", $newImageName)) {
                    $data = [
                        "name" => $this->request->getVar("name"),
                        "email" => $this->request->getVar("email"),
                        "profile_image" => "/images/" . $newImageName
                    ];

                    $employeeObject = new EmployeeModel();
                    if ($employeeObject->insert($data)) {
                        $res = [
                            "status" => true,
                            "message" => "success",
                            "data" => []
                        ];
                    } else {
                        $res = [
                            "status" => false,
                            "message" => "failed to create employee",
                            "data" => []
                        ];
                    }
                } else {
                    $res = [
                        "status" => false,
                        "message" => "failed to upload image",
                        "data" => []
                    ];
                }
            } else {
                $data = [
                    "name" => $this->request->getVar("name"),
                    "email" => $this->request->getVar(("email"))
                ];

                $employeeObject = new EmployeeModel();

                if ($employeeObject->insert($data)) {
                    $res = [
                        "status" => true,
                        "message" => "employee success",
                        "data" => []
                    ];
                } else {
                    $res = [
                        "status" => false,
                        "message" => "failed to create employee",
                        "data" => []
                    ];
                }
            }
        }

        return $this->respondCreated(($res));
    }

    public function updateEmployee($employeeId)
    {
        $this->setCorsHeaders();
        $employee = new EmployeeModel();

        $data = $employee->find($employeeId);

        if (!empty($data)) {

            $rules = [
                "name" => "required",
                "email" => "required|valid_email",
            ];

            if (!$this->validate($rules)) {
                $res = [
                    "status" => false,
                    "message" => $this->validator->getErrors(),
                    "data" => []
                ];
            } else {
                $fileImage = $this->request->getFile("profile_image");

                if (!empty($fileImage)) {
                    $fileName = $fileImage->getName();

                    $temp = explode(".", $fileName);

                    $newImageName = uniqid() . mt_rand() . "." . end($temp);

                    if ($fileImage->move("images", $newImageName)) {
                        $updatedData = [
                            "name" => $this->request->getVar("name"),
                            "email" => $this->request->getVar("email"),
                            "profile_image" => "/images/" . $newImageName
                        ];

                        if ($employee->update($employeeId, $updatedData)) {
                            $res = [
                                "status" => true,
                                "message" => "successful updated",
                                "data" => []
                            ];
                        } else {
                            $res = [
                                "status" => false,
                                "message" => "failed to update",
                                "data" => []
                            ];
                        }
                    } else {
                        $res = [
                            "status" => false,
                            "message" => "failed to upload image",
                            "data" => []
                        ];
                    }
                } else {
                    $updatedData = [
                        "name" => $this->request->getVar("name"),
                        "email" => $this->request->getVar("email"),
                    ];

                    if ($employee->update($employeeId, $updatedData)) {
                        $res = [
                            "status" => true,
                            "message" => "successful updated",
                            "data" => []
                        ];
                    } else {
                        $res = [
                            "status" => false,
                            "message" => "failed to update",
                            "data" => []
                        ];
                    }
                }
            }
        } else {
            $res = [
                "status" => false,
                "message" => "employee not found",
                "data" => []
            ];
        }

        return $this->respondCreated($res);
    }

    public function deleteEmployee($employeeId)
    {
        $this->setCorsHeaders();
        $employee = new EmployeeModel();

        $data = $employee->find($employeeId);

        if (!empty($data)) {
            if ($employee->delete($employeeId)) {
                $res = [
                    "status" => true,
                    "message" => "deleted successful",
                    "data" => []
                ];
            } else {
                $res = [
                    "status" => false,
                    "message" => "deleted failed",
                    "data" => []
                ];
            }
        } else {
            $res = [
                "status" => false,
                "message" => "Employee not found",
                "data" => []
            ];
        }

        return $this->respondCreated($res);
    }
}
