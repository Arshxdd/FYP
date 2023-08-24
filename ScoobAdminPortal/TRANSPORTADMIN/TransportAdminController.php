<?php
include("../CLASSES/Transport.php");

class ViewAllBuses{
    public static function viewAllBuses(){
        $viewAllBuses = new Transport();
        $results = $viewAllBuses->viewAllBuses();
        return $results;
    }
}

class ViewBus{
    public static function viewBus($busID){
        $viewBus = new Transport();
        $results = $viewBus->viewBus($busID);
        return $results;
    }
}

class AddBus{
    public static function addBus($busID){
        $addBus = new Transport();
        $results = $addBus->addBus($busID);
        return $results;
    }
}

class DeleteBus{
    public static function deleteBus($busID){
        $deleteBus = new Transport();
        $results = $deleteBus->deleteBus($busID);
        return $results;
    }
}

class SearchBus{
    public static function searchBus($searchQuery){
        $searchBus = new Transport();
        $results = $searchBus->searchBus($searchQuery);
        return $results;
    }
}

class ViewAllDrivers{
    public static function viewAllDrivers(){
        $viewAllDrivers = new Transport();
        $results = $viewAllDrivers->viewAllDrivers();
        return $results;
    }
}

class ViewDriver{
    public static function viewDriver($driverID){
        $viewDriver = new Transport();
        $results = $viewDriver->viewDriver($driverID);
        return $results;
    }
}

class AddDriver{
    public static function addDriver($driverID, $fname, $lname, $phone, $email, $password){
        $addDriver = new Transport();
        $results = $addDriver->addDriver($driverID, $fname, $lname, $phone, $email, $password);
        return $results;
    }
}

class AssignDriver{
    public static function assignDriver($driverID, $busID){
        $assignDriver = new Transport();
        $results = $assignDriver->assignDriver($driverID, $busID);
        return $results;
    }
}

class UnassignDriver{
    public static function unassignDriver($driverID, $busID){
        $unassignDriver = new Transport();
        $results = $unassignDriver->unassignDriver($driverID, $busID);
        return $results;
    }
}

class DeleteDriver{
    public static function deleteDriver($driverID){
        $deleteDriver = new Transport();
        $results = $deleteDriver->deleteDriver($driverID);
        return $results;
    }
}

class SearchDriver{
    public static function searchDriver($searchQuery){
        $searchDriver = new Transport();
        $results = $searchDriver->searchDriver($searchQuery);
    }
}

class ImportTransport{
    public static function importTransport($csv_file_1, $csv_file_2, $csv_file_3){
        $importTransport = new Transport();
        $results = $importTransport->importTransport($csv_file_1, $csv_file_2, $csv_file_3);
        return $results;
    }
}

class CheckPair{
    public static function checkPair($uen){
        $checkPair = new Transport();
        $results = $checkPair->checkPair($uen);
        return $results;
    }
}

class AvailablePair{
    public static function availablePair($uen){
        $availablePair = new Transport();
        $results = $availablePair->availablePair($uen);
        return $results;
    }
}

class SetPair{
    public static function setPair($uen, $busuen){
        $setPair = new Transport();
        $results = $setPair->setPair($uen, $busuen);
        return $results;
    }
}

class GetTransportDetails{
    public static function getTransportDetails(){
        $getTransportDetails = new Transport();
        $results = $getTransportDetails->getTransportDetails();
        return $results;
    }
}

class GetNoAssignBus{
    public static function getNoAssignBus(){
        $getNoAssignBus = new Transport();
        $results = $getNoAssignBus->getNoAssignBus();
        return $results;
    }
}

class AssignBus{
    public static function assignBus($busid, $driverid){
        $assignBus = new Transport();
        $results = $assignBus->assignBus($busid, $driverid);
        return $results;
    }
}

class ViewAllRoutes{
    public static function viewAllRoutes(){
        $viewAllRoutes = new Transport();
        $results = $viewAllRoutes->viewAllRoutes();
        return $results;
    }
}

class GetPostalGroup{
    public static function getPostalGroup(){
        $getPostalGroup = new Transport();
        $results = $getPostalGroup->getPostalGroup();
        return $results;
    }
}

class AddRoute{
    public static function addRoute($pcode, $busid){
        $addRoute = new Transport();
        $results = $addRoute->addRoute($pcode, $busid);
        return $results;
    }
}

class UnassignArea{
    public static function unassignArea($busid, $pcode){
        $unassignArea = new Transport();
        $results = $unassignArea->unassignArea($busid, $pcode);
        return $results;
    }
}

class GetTrips{
    public static function getTrips(){
        $getTrips = new Transport();
        $results = $getTrips->getTrips();
        return $results;
    }
}

class GetStudents{
    public static function getStudents($busid){
        $getStudents = new Transport();
        $results = $getStudents->getStudents($busid);
        return $results;
    }
}

class GetCompanyData{
    public static function getCompanyData(){
        $getCompanyData = new Transport();
        $results = $getCompanyData->getCompanyData();
        return $results;
    }
}