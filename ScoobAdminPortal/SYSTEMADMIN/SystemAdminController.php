<?php
include("../CLASSES/Applications.php");

class ViewPendingApplications
{
    public static function viewPendingApplications()
    {
        $viewPendingApplications = new Applications();
        $results = $viewPendingApplications->viewPendingApplications();
        return $results;
    }
}

class ViewSchoolApplication
{
    public static function viewSchoolApplication($uen)
    {
        $viewSchoolApplication = new Applications();
        $results = $viewSchoolApplication->viewSchoolApplication($uen);
        return $results;
    }
}

class ApproveSchool
{
    public static function approveSchool($uen)
    {
        $approveSchool = new Applications();
        $results = $approveSchool->approveSchool($uen);
        return $results;
    }
}

class RejectSchool
{
    public static function rejectSchool($uen)
    {
        $rejectSchool = new Applications();
        $results = $rejectSchool->rejectSchool($uen);
        return $results;
    }
}

class ViewTransportApplication
{
    public static function viewTransportApplication($uen)
    {
        $viewTransportApplication = new Applications();
        $results = $viewTransportApplication->viewTransportApplication($uen);
        return $results;
    }
}

class ApproveTransport
{
    public static function approveTransport($uen)
    {
        $approveTransport = new Applications();
        $results = $approveTransport->approveTransport($uen);
        return $results;
    }
}

class RejectTransport
{
    public static function rejectTransport($uen)
    {
        $rejectTransport = new Applications();
        $results = $rejectTransport->rejectTransport($uen);
        return $results;
    }
}

class SearchApplications
{
    public static function searchApplications($searchQuery)
    {
        $searchApplications = new Applications();
        $results = $searchApplications->searchApplications($searchQuery);
        return $results;
    }
}

class ViewPastApplications
{
    public static function viewPastApplications()
    {
        $viewPastApplications = new Applications();
        $results = $viewPastApplications->viewPastApplications();
        return $results;
    }
}

class ViewPastSchoolApplication
{
    public static function viewPastSchoolApplication($uen)
    {
        $viewPastSchoolApplication = new Applications();
        $results = $viewPastSchoolApplication->viewPastSchoolApplication($uen);
        return $results;
    }
}

class ViewPastTransportApplication
{
    public static function viewPastTransportApplication($uen)
    {
        $viewPastTransportApplication = new Applications();
        $results = $viewPastTransportApplication->viewPastTransportApplication($uen);
        return $results;
    }
}

class SearchPastApplications
{
    public static function searchPastApplications($searchQuery)
    {
        $searchPastApplications = new Applications();
        $results = $searchPastApplications->searchPastApplications($searchQuery);
        return $results;
    }
}
