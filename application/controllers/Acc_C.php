<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acc_C extends CI_Controller {

    // private $date;

    public function __construct(){
        parent::__construct();
        $this->load->model('Absen_M');
        date_default_timezone_set("Asia/Jakarta");
        // $this->date = date('Y-m-d');
        if (!$this->session->userdata('logged_in')){
            redirect();
        }
    }

    public function lihat_perbulan()
    {
        $date = date('Y-m-d');
        $datar['data_s'] = $this->Absen_M->rawQuery("SELECT * FROM data_s");
        $datar['bulan'] = substr($date,-5,2);
        $datar['tahun'] = substr($date,-10,4);

        $this->load->view('html/header');
        $this->load->view('html/menu');
        $this->load->view('modal_acc',$datar);
        $this->load->view('acc');
        $this->load->view('javaskrip');
        $this->load->view('html/footer');
    }
    public function lihat_pertanggal()
    {        
        $date = date('Y-m-d');
        $datar['data_s'] = $this->Absen_M->rawQuery("SELECT * FROM data_s");
        $datar['tanggal'] = substr($date,-2,2);
        $datar['bulan'] = substr($date,-5,2);
        $datar['tahun'] = substr($date,-10,4);

        $this->load->view('html/header');
        $this->load->view('html/menu');
        $this->load->view('modal_acc',$datar);
        $this->load->view('acc_pertanggal');
        $this->load->view('javaskrip');
        $this->load->view('html/footer');
    }
    public function show()
    {
        $date = $this->input->post('vtanggal');
        $datar['absen']= $this->Absen_M->rawQuery("SELECT 
            data_ra.id_a, 
            data_s.keterangan_s,
            data_ra.detail, 
            data_ra.tanggal, 
            data_ra.jam, 
            data_ra.acc, 
            data_ra.id_k,
            data_ra.denda, 
            data_k.nama_k 
            FROM data_ra
            INNER JOIN data_k ON data_ra.id_k = data_k.id_k
            INNER JOIN data_s ON data_ra.id_s = data_s.id_s
            WHERE tanggal LIKE'".$date."%' ORDER BY data_ra.id_a DESC")->result();
        $datar['ijin']= $this->Absen_M->rawQuery("SELECT data_k.nama_k, data_k.id_k, data_i.perihal, data_i.end, data_i.start, data_i.tanggal, data_i.id_i,data_i.denda FROM data_i INNER JOIN data_k ON data_i.id_k = data_k.id_k WHERE tanggal LIKE '".$date."%' ")->result();
        $datar['data_s'] = $this->Absen_M->rawQuery("SELECT * FROM data_s")->result();
        echo json_encode($datar);
    }
    public function acceptAbsen()
    {
    	$dataUpdate['acc'] = 1;
    	$dataCondition['id_a'] = $this->input->post('id_acc');
    	$result = $this->Absen_M->update('data_ra',$dataCondition,$dataUpdate);
    	if($result){
			$alert_update_absen_acc = "<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong> absen berhasil di ACC!</strong></div>";
			// $this->session->set_flashdata('alert_update_absen_acc', $alert_update_absen_acc);
		}
		else{
			$alert_update_absen_acc = "<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong>absen gagal di acc! </strong></div>";
			// $this->session->set_flashdata('alert_update_absen_acc', $alert_update_absen_acc);
		}
        echo $alert_update_absen_acc;
		// redirect('Acc_C/lihat/'.$bulan.'/'.$tahun);
    	
    }
    public function rejectAbsen()
    {
    	$dataUpdate['acc'] = 0;
    	$dataCondition['id_a'] = $this->input->post('id_rej');
    	$result = $this->Absen_M->update('data_ra',$dataCondition,$dataUpdate);
    	if($result){
			$alert_update_absen_acc = "<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong> absen berhasil di tolak!</strong></div>";
			// $this->session->set_flashdata('alert_update_absen_acc', $alert_update_absen_acc);
        }
        else{
            $alert_update_absen_acc = "<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong>absen gagal di tolak! </strong></div>";
            // $this->session->set_flashdata('alert_update_absen_acc', $alert_update_absen_acc);
        }
        // redirect('Acc_C/lihat/'.$bulan.'/'.$tahun);
        echo $alert_update_absen_acc;
    }
    
    public function deleteAbsen(){
        $dataCondition['id_a'] = $this->input->post('id_del');
        $result = $this->Absen_M->delete('data_ra',$dataCondition);
        if($result){
            $alert_update_absen_acc = "<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong>Delete Absensi Berhasil! </strong> </div>";
            //$this->session->set_flashdata('alert_update_absen_acc', $alert_update_absen_acc);
        }
        else{
            $alert_update_absen_acc = "<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong>Delete Absensi Gagal! </strong></div>";
            // $this->session->set_flashdata('alert_update_absen_acc', $alert_update_absen_acc);
        }
        echo $alert_update_absen_acc;
        unset($dataCondition,$result,$data);
        // redirect('Acc_C/lihat/'.$bulan.'/'.$tahun);
    }

    public function edit_absensi_ku_dariacc($data){

        $datax['detail_absen'] = $this->Absen_M->rawQuery("select * from data_ra
                                                            inner join data_k on data_ra.id_k = data_k.id_k
                                                            inner join data_s on data_ra.id_s = data_s.id_s
                                                            where data_ra.id_a = ".$data);
        echo json_encode($datax['detail_absen']->result_array());
    
        
    }
    public function edit_ijin_ku_dari_acc($data){
        $datax['ijin_ku'] = $this->Absen_M->rawQuery("SELECT data_i.id_i,data_i.id_k,data_i.perihal,data_i.start,data_i.end,data_i.tanggal,data_i.denda,data_k.nama_k
                                                        FROM data_i
                                                        INNER JOIN data_k ON data_i.id_k = data_k.id_k
                                                        WHERE id_i =".$data)->result();
        echo json_encode($datax['ijin_ku']);
    }
    
    public function update_absensi_ku(){
        if ($this->input->post() != null) {
            
            $dataCondition['id_a'] = $this->input->post('u_id_a');
            $dataCondition['id_k'] = $this->input->post('u_id_k');
            
            $data['id_s'] = $this->input->post('u_keterangan');
            $data['tanggal'] = $this->input->post('u_tanggal');
            $data['jam'] = $this->input->post('u_jam');
            $data['acc'] = $this->input->post('u_acc');

            $where_idm['id_m'] =  1;
            $datax['jam_masuk'] = $this->Absen_M->read('data_m',$where_idm)->result();
            $jam_masuk = $datax['jam_masuk'][0]->misc;

            $where_idm['id_m'] =  4;
            $datax['jam_pulang'] = $this->Absen_M->read('data_m',$where_idm)->result();
            $jam_pulang = $datax['jam_pulang'][0]->misc;
            unset($where_idm,$datax);
            if ($data['id_s'] == 1) {
                if ($data['jam'] > $jam_masuk) {
                    $data['detail'] = "telat";

                    $time1 = strtotime($data['jam']);
                    $time2 = strtotime($jam_masuk);

                    $seperempat = round(1/4 ,2);
                    $difference = round(abs($time1 - $time2) / 3600,2)  /*% $seperempat*/;
                    $difference = floor($difference / $seperempat);
                    
                    $where_idm['id_m'] =  7;
                    $datax['denda_terlambat'] = $this->Absen_M->read('data_m',$where_idm)->result();
                    $denda_terlambat = $datax['denda_terlambat'][0]->misc;
                    unset($where_idm,$datax);

                    $data['denda'] = $difference * $denda_terlambat;
                }
                else{
                    $data['detail'] = "tepat waktu";
                    $data['denda'] = 0;   
                }
            }
            elseif ($data['id_s'] == 5) {
                $time1 = strtotime($jam_masuk);
                $time2 = strtotime($jam_pulang);

                $seperempat = round(1/4 ,2);
                $difference = round(abs($time2 - $time1) / 3600,2)-1  /*% $seperempat*/;
                // echo "DIFFERENCE:".$difference;
                // die(); 
                // echo $data['jam']."<br>";
                // echo $jam_masuk."<br>";
                // echo $time1."<br>";
                // echo $time2."<br>";
                // echo "DIFF :".$difference."<br>";
                $difference = floor($difference / $seperempat);
                
                $where_idm['id_m'] =  8;
                $datax['denda_alpha'] = $this->Absen_M->read('data_m',$where_idm)->result();
                $denda_alpha = $datax['denda_alpha'][0]->misc;
                unset($where_idm,$datax);

                $data['denda'] = $difference * $denda_alpha;
                $data['detail'] = $this->input->post('c_detail');
            }
            elseif ($data['id_s'] == 6) {
                $where_idm['id_m'] =  5;
                $datax['denda_ijin_1_hari'] = $this->Absen_M->read('data_m',$where_idm)->result();
                $denda_ijin_1_hari = $datax['denda_ijin_1_hari'][0]->misc;
                unset($where_idm,$datax);               
                $time1 = strtotime($jam_masuk);
                $time2 = strtotime($jam_pulang);
                $difference = round(abs($time2 - $time1) / 3600,2);
                $difference = $difference * $denda_ijin_1_hari;
                $data['denda'] = $difference;
                $data['detail'] = $this->input->post('u_detil_keterangan');
            }
            else{
                $data['detail'] = $this->input->post('u_detil_keterangan');
                $data['denda'] = 0;
            }
            $datas['id_k'] = $dataCondition['id_k'];
            $datalike['tanggal'] = $data['tanggal'];
            $result = $this->Absen_M->update('data_ra',$dataCondition,$data);
            $results = json_decode($result, true);
            if ($results['status']) {
                    $alert_update_absensi_ku = "<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong>Update Absensi Berhasil! </strong> </div>";
                // $this->session->set_flashdata('alert_update_absensi_ku', $alert_update_absensi_ku);
            }
            else{
                if ($results['error_message']['code'] == 1062) {
                    $alert_update_absensi_ku = "<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong>Update Absensi Berhasil! </strong> </div>";
                // $this->session->set_flashdata('alert_update_absensi_ku', $alert_update_absensi_ku);
                }else{
                    $alert_update_absensi_ku = "<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong>Update Absensi eror! </strong> </div>";
                    // $this->session->set_flashdata('alert_update_absensi_ku', $alert_update_absensi_ku);
                }
            }
            // redirect('Acc_C/lihat/'.$tanggal."/".$tahun);
            echo $alert_update_absensi_ku;
        }
    }

    public function update_ijin_ku(){
        if ($this->input->post() != null) {
            $dataCondition['id_i'] = $this->input->post('u_id_i');
            // $data['id_k'] = $this->input->post('u_id_k');
            $data['perihal'] = $this->input->post('u_perihal');
            $data['start'] = $this->input->post('u_start');
            $data['end'] = $this->input->post('u_end');
            $data['tanggal'] = $this->input->post('u_tanggal');

            $tanggal = substr($data['tanggal'],-5,2);
            $tahun = substr($data['tanggal'],-10,4);

            $time1 = strtotime($data['start']);
            $time2 = strtotime($data['end']);
            $difference = round(abs($time2 - $time1) / 3600,2);

            $where_idm['id_m'] =  6;
            $datax['denda_ijin'] = $this->Absen_M->read('data_m',$where_idm)->result();
            $denda_ijin = $datax['denda_ijin'][0]->misc;
            unset($where_idm,$datax);

            $where_idm['id_m'] =  4;
            $datax['jam_pulang'] = $this->Absen_M->read('data_m',$where_idm)->result();
            $jam_pulang = $datax['jam_pulang'][0]->misc;
            unset($datax,$where_idm);

            $difference = round(ceil($difference), 0, PHP_ROUND_HALF_UP);
            $data['denda']= $difference * $denda_ijin;

            if ($data['end'] > $jam_pulang) {
                $data['end'] = $jam_pulang;
            }

            $where_idm['id_m'] =  1;
            $datax['jam_masuk'] = $this->Absen_M->read('data_m',$where_idm)->result();
            $jam_masuk = $datax['jam_masuk'][0]->misc;
            unset($where_idm);

            if ($data['start'] < $jam_masuk ) {
                $alert_update_ijin_acc =  "<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong>Ijin gagal! perbaiki jam ijin start</strong> Inputan jam diluar jam kerja</div>";
            }

            else{

                $result = $this->Absen_M->update('data_i',$dataCondition,$data);
                $results = json_decode($result, true);
                /*false  object*/
                /*true  array*/
                if ($results['status']) {
                    $alert_update_ijin_acc = "<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Update Ijin Berhasil!</strong></div>";
                }else{
                    if ($results['error_message']['code'] == 1062) {
                        $alert_update_ijin_acc = "<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Update Ijin gagal! Email telah terdaftar</strong></div>";
                    }else{
                        $alert_update_ijin_acc = "<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Update Ijin gagal!</strong></div>";
                    }
                }
            }
            echo json_encode($alert_update_ijin_acc);
        }
    }
    public function delete_ijinku()
    {
        $dataCondition['id_i'] = $this->input->post('id_del');
        $result = $this->Absen_M->delete('data_i',$dataCondition);
        if($result){
            $alert_delete_ijin_acc = "<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong>Delete Ijin Berhasil! </strong> </div>";
            $this->session->set_flashdata('alert_delete_ijin_acc', $alert_delete_ijin_acc);
        }
        else{
            $alert_delete_ijin_acc = "<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong>Delete Ijin Gagal! </strong></div>";
            $this->session->set_flashdata('alert_delete_ijin_acc', $alert_delete_ijin_acc);
        }
        echo json_encode($alert_delete_ijin_acc);
    }
}