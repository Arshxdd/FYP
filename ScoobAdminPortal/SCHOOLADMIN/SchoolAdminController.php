<?php
include("../CLASSES/School.php");

class ViewAllClasses{
    public static function viewAllClasses(){
        $viewAllClasses = new School();
        $results = $viewAllClasses->viewAllClasses();
        return $results;
    }
}

class ViewClass{
    public static function viewClass($class){
        $viewClassList = new School();
        $results = $viewClassList->viewClass($class);
        return $results;
    }
}

class AddClass{
    public static function addClass($class){
        $addClass = new School();
        $results = $addClass->addClass($class);
        return $results;
    }
}

class SearchClass{
    public static function searchClass($searchQuery){
        $searchClass = new School();
        $results = $searchClass->searchClass($searchQuery);
        return $results;
    }
}

class DeleteClass{
    public static function deleteClass($class){
        $deleteClass = new School();
        $results = $deleteClass->deleteClass($class);
        return $results;
    }
}

class ViewAllStudents{
    public static function viewAllStudents(){
        $viewAllStudents = new School();
        $results = $viewAllStudents->viewAllStudents();
        return $results;
    }
}

class AddStudent{
    public static function addStudent($studentid, $fname, $lname, $class, $pcode, $parentid){
        $addStudent = new School();
        $results = $addStudent->addStudent($studentid, $fname, $lname, $class, $pcode, $parentid);
        return $results;
    }
}

class ViewStudent{
    public static function viewStudent($studentid){
        $viewStudent = new School();
        $results = $viewStudent->viewStudent($studentid);
        return $results;
    }
}

class SearchStudent{
    public static function searchStudent($searchQuery){
        $searchStudent = new School();
        $results = $searchStudent->searchStudent($searchQuery);
        return $results;
    }
}


class DeleteStudent
{
    public static function deleteStudent($studentid)
    {
        $deleteStudent = new School();
        $results = $deleteStudent->deleteStudent($studentid);
        return $results;
    }
}



class ViewAllTeachers{
    public static function viewAllTeachers(){
        $viewAllTeachers = new School();
        $results = $viewAllTeachers->viewAllTeachers();
        return $results;
    }
}

class AddTeacher{
    public static function addTeacher($fname, $lname, $teacherid, $email, $password, $class){
        $addTeacher = new School();
        $results = $addTeacher->addTeacher($fname, $lname, $teacherid, $email, $password, $class);
        return $results;
    }
}

class ViewTeacher{
    public static function viewTeacher($teacherid){
        $viewTeacher = new School();
        $results = $viewTeacher->viewTeacher($teacherid);
        return $results;
    }
}

class SearchTeacher{
    public static function searchTeacher($searchQuery){
        $searchTeacher = new School();
        $results = $searchTeacher->searchTeacher($searchQuery);
        return $results;
    }
}

class DeleteTeacher{
    public static function deleteTeacher($teacherid){
        $deleteTeacher = new School();
        $results = $deleteTeacher->deleteTeacher($teacherid);
        return $results;
    }
}

class ImportSchool{
    public static function importSchool($csv_file_1, $csv_file_2, $csv_file_3){
        $importSchool = new School();
        $results = $importSchool->importSchool($csv_file_1, $csv_file_2, $csv_file_3);
        return $results;
    }
}

class GetActiveClass{
    public static function getActiveClass(){
        $getActiveClass = new School();
        $results = $getActiveClass->getActiveClass();
        return $results;
    }
}

class GetSchoolData{
    public static function getSchoolData(){
        $getSchoolData = new School();
        $results = $getSchoolData->getSchoolData();
        return $results;
    }
}

class GetClassNoTeacher{
    public static function getClassNoTeacher(){
        $getClassNoTeacher = new School();
        $results = $getClassNoTeacher->getClassNoTeacher();
        return $results;
    }
}

class AssignTeacherClass{
    public static function assignTeacherClass($teacherid, $class){
        $assignTeacherClass = new School();
        $results = $assignTeacherClass->assignTeacherClass($teacherid, $class);
        return $results;
    }
}

class AssignStudentClass{
    public static function assignStudentClass($studentid, $classid){
        $assignStudentClass = new School();
        $results = $assignStudentClass->assignStudentClass($studentid, $classid);
        return $results;
    }
}

class GetTrips{
    public static function getTrips(){
        $getTrips = new School();
        $results = $getTrips->getTrips();
        return $results;
    }
}

class GetStudents{
    public static function getStudents($busid){
        $getStudents = new School();
        $results = $getStudents->getStudents($busid);
        return $results;
    }
}

?>