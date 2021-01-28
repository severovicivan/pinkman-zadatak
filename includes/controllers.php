<?php

class ViewUser extends User {
    
    public function showAllUsers() {
        $datas = $this->getAllUsers();
        return $datas;
        // foreach ($datas as $data) {
        //     foreach($data as $key => $value){
        //         echo $this->{$key} = $value;
        //         echo '<br>';
        //     }
        //     echo '<br>';
            // echo $data['firstname']." ";
            // echo $data['lastname']."<br>";
        }
    }

class ViewCountry extends Country {
    
    public function showAllCountries() {
        $datas = $this->getAllCountries();
        $zemlje = [];
        foreach ($datas as $data) {
            $zemlja = [];
            foreach($data as $key => $value){
                array_push($zemlja, $zemlja[$key] = $value);
            }
            array_push($zemlje, $zemlja);
        }
        return $zemlje;
    }
}

class ViewStatus extends Status {
    
    public function showAllStatuses() {
        $datas = $this->getAllStatuses();
        $statusi = [];
        foreach ($datas as $data) {
            $status = [];
            foreach($data as $key => $value){
                array_push($status, $status[$key] = $value);
            }
            array_push($statusi, $status);
        }
        return $statusi;
    }
}