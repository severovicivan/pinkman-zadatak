<?php
    include 'includes/db.php';
    include 'includes/models.php';
    include 'includes/controllers.php';
    include 'includes/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinkman zadatak</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
</head>
<body>
    <h2 class="d-flex justify-content-center mt-3">Tablica korisnika</h2>
    <div class="mt-5 col-12 d-flex justify-content-center">
        <?php
            $countries = new ViewCountry();
            $zemlje = $countries->showAllCountries();
            $statuses = new ViewStatus();
            $statusi = $statuses->showAllStatuses();
            $users = new ViewUser();
            $korisnici = $users->showAllUsers();
            $user_list = [];
            foreach ($korisnici as $korisnik) {
                $user = [];
                foreach($korisnik as $svojstvo => $vrijednost){
                    if ($svojstvo == 'status') {
                        foreach ($statusi as $status) {
                            if ($status['id'] == $vrijednost) {
                                // echo $svojstvo.' - '.$status['name'];
                                array_push($user, $user[$svojstvo] = $status['name']);
                            }
                        }
                    } elseif ($svojstvo == 'country') {
                        foreach ($zemlje as $zemlja) {
                            if ($zemlja['id'] == $vrijednost) {
                                // echo $svojstvo.' - '.$zemlja['name'];
                                array_push($user, $user[$svojstvo] = $zemlja['name']);
                            }
                        }
                    } else {
                        // echo $svojstvo.' - '.$vrijednost;
                        array_push($user, $user[$svojstvo] = $vrijednost);
                    }
                }
                array_push($user_list, $user);
            }
        ?>
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Day of Birth</th>
                        <th>Country</th>
                        <th>City</th>
                        <th>Status</th>
                        <th>Transactions</th>
                    </tr>
                </thead>
                <tbody id="uid">
                    <?php 
                        foreach ($user_list as $user) {
                            echo '
                                <tr>
                                    <td>'.$user['id'].'</td>
                                    <td>'.$user['firstname'].'</td>
                                    <td>'.$user['lastname'].'</td>
                                    <td>'.$user['email']. '</td>
                                    <td>'.$user['dob'].'</td>
                                    <td>'.$user['country'].'</td>
                                    <td>'.$user['city'].'</td>
                                    <td>'.$user['status'].'</td>
                                    <td class="d-flex justify-content-center">
                                    <button type="button" class="btn btn-primary showmodal" 
                                    data-toggle="modal" data-id="'.$user['id'].'" data-target="#myModal">
                                        View
                                    </button></td>
                                </tr>
                            ';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <div class="col-12 mt-5">
        <h2 class="d-flex justify-content-center">Popis transakcija</h2>
        <div class="row d-flex justify-content-center mt-4" id="radiodiv">
            <p style="margin-top:0.8em;margin-right:0.5em"><b>Odaberi tip kartice: </b></p>
            <div class="form-check-inline">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" value="Maestro" name="optradio">Maestro
            </label>
            </div>
            <div class="form-check-inline">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" value="Visa" name="optradio">Visa
            </label>
            </div>
            <div class="form-check-inline disabled">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" value="Mastercard" name="optradio">MasterCard
            </label>
            </div>
        </div>
        <div class="row mt-3 mx-5 d-flex justify-content-center">
            <table class="table" id="myTable1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Amount</th>
                        <th>Currency</th>
                        <th>Card</th>
                        <th>Date</th>
                        <th>Processed</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <div class="col-12 mt-5">
        <h2 class="d-flex justify-content-center">Transakcije po državi</h2>
        <div class="mt-3 mx-5">
            <table class="table">
                <thead>
                    <tr>
                        <th>Country</th>
                        <th>Amount</th>
                        <th>Currency</th>
                        <th>Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $all = countrySum();
                        try {
                            $rate = convertMoney();
                            printf('Na današnji dan 1 USD = %.2f EUR',$rate);
                        } catch (\Throwable $th) {
                            $rate = 0.83;
                            printf('Konverzija (28.1.2021.) 1 USD = %.2f EUR',$rate);
                            print_r($th);
                        }
                        $fp = fopen('country_transactions.csv', 'w');
                        $header = ['Country','Amount','Currency','Count'];
                        fputcsv($fp,$header);
                        foreach ($all as $user) {
                            echo '
                                <tr>
                                    <td>'.$user[0].'</td>
                                    <td>'.$user[1].'</td>
                                    <td>'.$user[2].'</td>
                                    <td>'.$user[3].'</td>
                                </tr>
                            ';
                            fputcsv($fp,$user);
                        }
                        fclose($fp);
                    ?>
                </tbody>
            </table>
        </div>
        <hr>
        <h2 class="d-flex justify-content-center mb-3 mt-5">Transakcije po korisniku i mjesecu</h2>
        <div class="d-flex justify-content-center mb-5">
            <div>
                <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <?php 
                    $months = uniqueMonths();
                    foreach ($months as $month) {
                        echo '<a class="nav-item nav-link" id="nav-'.$month.'-tab" data-toggle="tab" href="#nav-'.$month.'" role="tab" aria-controls="nav-home" aria-selected="true">'.$month.'</a>';
                    }?>
                </div>
                </nav>    
                <div class="tab-content" id="nav-tabContent">
                    <?php 
                    $months = uniqueMonths();
                    $users = userMonth();
                    $counter = 0;
                    foreach ($months as $month) {
                        echo '<div class="tab-pane fade" id="nav-'.$month.'" role="tabpanel" aria-labelledby="nav-'.$month.'-tab">'.
                        '<table class="table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Amount</th>
                                    <th>Currency</th>
                                    <th>Count</th>
                                </tr>
                            </thead>
                            <tbody>';
                            $fp = fopen('user_'.$month.'_transactions.csv', 'w');
                            $header = ['User','Amount','Currency','Count'];
                            fputcsv($fp,$header);
                            foreach (array_values($users)[$counter] as $user) {
                                echo '
                                <tr>
                                    <td>'.$user[0].'</td>
                                    <td>'.$user[1].'</td>
                                    <td>'.$user[2].'</td>
                                    <td>'.$user[3].'</td>
                                </tr>
                                ';
                                fputcsv($fp,$user);
                            }
                            fclose($fp);
                            echo '</tbody></table></div>';
                        $counter += 1;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog mw-100 w-75" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Amount</th>
                        <th>Currency</th>
                        <th>Card</th>
                        <th>Date</th>
                        <th>Processed</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>
</html>

<!-- JS code -->
<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<!--JS below-->


<!-- JS modal -->
<script>
$(document).on("click", ".showmodal", function () {
    var userId = $(this).data('id');
    console.log(userId);
    $.ajax({
        url: "https://pinkman.online/api/?api-key=any",
        type: 'GET',
        dataType: 'json', // added data type
        success: function(res) {
            var transactions = res['data'];
            var data = [];
            $('#myTable > tbody').html('');
            $.each(transactions, function(n, elem) {
                if (elem['user_id'] == userId) {
                    $('#myTable > tbody').append(
                        '<tr><td>'+elem['id']+'</td>'+
                        '<td>'+elem['amount']+'</td>'+
                        '<td>'+elem['currency']+'</td>'+
                        '<td>'+elem['type']+'</td>'+
                        '<td>'+elem['date']+'</td>'+
                        '<td>'+elem['processed']+'</td>'+
                        '<td>'+elem['details']+'</td></tr>');
                    data.push(elem);
                }  
            });
            console.log(data);
        }
    });
    $('#myInput').trigger('focus');
})

$('#radiodiv input').on('change', function() {
   var card = $('input[name=optradio]:checked', '#radiodiv').val();
   $.ajax({
        url: "https://pinkman.online/api/?api-key=any",
        type: 'GET',
        dataType: 'json', // added data type
        success: function(res) {
            var transactions = res['data'];
            var data = [];
            $('#myTable1 > tbody').html('');
            $.each(transactions, function(n, elem) {
                if (elem['type'] == card) {
                    $('#myTable1 > tbody').append(
                        '<tr><td>'+elem['id']+'</td>'+
                        '<td>'+elem['amount']+'</td>'+
                        '<td>'+elem['currency']+'</td>'+
                        '<td>'+elem['type']+'</td>'+
                        '<td>'+elem['date']+'</td>'+
                        '<td>'+elem['processed']+'</td>'+
                        '<td>'+elem['details']+'</td></tr>');
                    data.push(elem);
                }  
            });
            console.log(data);
        }
    });
});
</script>