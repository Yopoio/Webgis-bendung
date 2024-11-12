<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategorihotspot extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('KategorihotspotModel','Model');
	}

	public function index()
	{
		$datacontent['url']='admin/kategorihotspot';
		$datacontent['title']='Halaman Kategori Struktur Air';
		$datacontent['datatable']=$this->Model->get();
		$data['content']=$this->load->view('admin/kategorihotspot/tableView',$datacontent,TRUE);
		$data['title']=$datacontent['title'];
		$this->load->view('admin/layouts/html',$data);
	}
	public function form($parameter='',$id='')
	{
		$datacontent['url']='admin/kategorihotspot';
		$datacontent['parameter']=$parameter;
		$datacontent['id']=$id;
		$datacontent['title']='Form Kategori Hotpost';
		$data['content']=$this->load->view('admin/kategorihotspot/formView',$datacontent,TRUE);
		$data['js']=$this->load->view('admin/kategorihotspot/js/formJs',$datacontent,TRUE);
		$data['title']=$datacontent['title'];
		$this->load->view('admin/layouts/html',$data);
	}
	public function simpan()
	{
		if($this->input->post()){
			
			// cek validasi
			$validation=null;
			// cek kode apakah sudah ada
			$this->db->where('kd_kategori_bendung',$this->input->post('kd_kategori_bendung'));
			$check=$this->db->get('m_kategori_bendung');
			if($check->num_rows()>0){
				$validation[]='Kode Kategori Sudah Ada';
			}
			$this->db->where('nm_kategori_bendung',$this->input->post('nm_kategori_bendung'));
			$check=$this->db->get('m_kategori_bendung');
			if($check->num_rows()>0){
				$validation[]='Kategori Struktur Air Sudah Ada';
			}
			//tidak boleh kosong
			if($this->input->post('kd_kategori_bendung')==''){
				$validation[]='Kode Kategori Tidak Boleh Kosong';
			} elseif (!is_numeric($this->input->post('kd_kategori_bendung'))) {
				$validation[]='Kode Kategori Harus Berupa Angka';
			}
			if($this->input->post('nm_kategori_bendung')==''){
				$validation[]='Kategori Struktur Air Tidak Boleh Kosong';
			}


			if(count($validation)>0){
				$this->session->set_flashdata('error_validation',$validation);
				$this->session->set_flashdata('error_value',$_POST);
				redirect($_SERVER['HTTP_REFERER']);
				return false;
			}
			// cek validasi

			
			$data=[
				'id_kategori_bendung'=>$this->input->post('id_kategori_bendung'),
				'nm_kategori_bendung'=>$this->input->post('nm_kategori_bendung'),
				'kd_kategori_bendung'=>$this->input->post('kd_kategori_bendung')
			];
			// upload
			if($_FILES['marker']['name']!=''){
				$upload=upload('marker','marker','image');
				if($upload['info']==true){
					$data['marker']=$upload['upload_data']['file_name'];
				}
				elseif($upload['info']==false){
					$info='<div class="alert alert-danger alert-dismissible">
	            		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            		<h4><i class="icon fa fa-ban"></i> Error!</h4> '.$upload['message'].' </div>';
					$this->session->set_flashdata('info',$info);
					redirect('admin/kategorihotspot');
					exit();
				}
			}
			// upload
			
			if($_POST['parameter']=="tambah"){
				$this->Model->insert($data);
			}
			else{
				$this->Model->update($data,['id_kategori_bendung'=>$this->input->post('id_kategori_bendung')]);
			}

		}
		redirect('admin/kategorihotspot');
	}

	public function hapus($id=''){
		// hapus file di dalam folder
		$this->db->where('id_kategori_bendung',$id);
		$get=$this->Model->get()->row();
		$marker=$get->marker;
		unlink('assets/unggah/marker/'.$marker);
		// end hapus file di dalam folder
		$this->Model->delete(["id_kategori_bendung"=>$id]);
		redirect('admin/kategorihotspot');
	}
}
