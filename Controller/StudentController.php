<?php

namespace App\Controller;

use App\Core\Application;
use App\Core\Controller;
use App\Model\Student;

class StudentController extends Controller {

    public function index() {
        $objStudent = new Student();

        $draw = 1;
        $student_data = ["Records"=>[], "TotalRecords"=>0];
        if($this->request->is_ajax()) {
            extract($this->helper->getDataGridData());
            
            if(!empty($keyword)) {
                $objStudent->setWhere(" and (name LIKE :name", [":name"=>$keyword]);
                $objStudent->setWhere(" or city LIKE :city)", [":city"=>$keyword]);
            }
            $objStudent->setLimit("LIMIT $start, $length");
            if(!empty($order_by)) $objStudent->setOrder($order_by);
            $student_data = $objStudent->findAll();
        }

        $row = [];
        $i=0;
        foreach($student_data["Records"] AS $key => $val) {
            $student_rows = array();
            $student_rows["id"] = ++$i;
            $student_rows["photo"] = '<img src="'.Application::$app->site_url.'Assets/UserImages/'.$val->image.'" alt="..." class="img-thumbnail">';
            $student_rows["name"] = $val->name;
            $student_rows["grade"] = $val->grade;
            $student_rows["city"] = $val->city;
            $delete_uri = Application::$app->site_url."student/delete/$val->id";
            $student_rows["action"] = '<a href="'.$delete_uri.'" class="btn btn-danger">Delete</a>';
            $row[] = $student_rows;
        }

        $out_put = [
            "draw" => $draw,
            "recordsTotal" => $student_data["TotalRecords"],
            'recordsFiltered' => $student_data["TotalRecords"],
            'data' => $row,
        ];
        if($this->request->is_ajax()) {
            echo json_encode($out_put);die;
        }
        return $this->render("students/students");
    }

    public function Add() {
        
        $objStudent = new Student();
        if($this->getRequestMethod() == "post") {
            $AllPostData = $this->request->postAll();
            $photo = $this->request->file("photo");
            $AllPostData["image"] = $photo["name"];
            $objStudent->loadData($AllPostData);
            if($objStudent->dataValidate()) {
                
                $fileTmpPath = $photo['tmp_name'];
                $fileName = $photo['name'];
                $fileSize = $photo['size'];
                $fileType = $photo['type'];

                move_uploaded_file($fileTmpPath, Application::$app->assets_path."UserImages/".$fileName);

                $inserted_id = $objStudent->save();
                
                $this->session->setFlash('success', 'Records is added successfully');
                $this->request->redirect('students/');
            }
            $data["errors"] = $objStudent->errors;
        }

        $data["gride_data"] = [
            "A+" => "A+",
            "A" => "A",
            "B" => "B",
            "C" => "C",
        ];
        return $this->render("students/add", $data);
    }

    public function Delete($id) {
        $objStudent = new Student();
        $objStudent->delete($id);
        $this->session->setFlash('success', 'Records has been deleted');
        $this->request->redirect('students/');
    }

}