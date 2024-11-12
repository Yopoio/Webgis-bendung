<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hotspot extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if($this->session->logged!==true){
			redirect('admin/auth');
		  }
		  if($this->session->level!=='Admin'){
			redirect('admin/beranda');
		  }
		$this->load->model('HotspotModel','Model');
		$this->load->model('KecamatanModel');
		$this->load->model('KategorihotspotModel');
	}

	public function index()
	{
		$datacontent['url']='admin/hotspot';
		$datacontent['title']='Halaman Bendung dan Pintu Air';
		$datacontent['datatable']=$this->Model->get();
		$data['content']=$this->load->view('admin/hotspot/tableView',$datacontent,TRUE);
		$data['js']=$this->load->view('admin/hotspot/js/tableJs',$datacontent,TRUE);
		$data['title']=$datacontent['title'];
		$this->load->view('admin/layouts/html',$data);
	}
	public function form($parameter='',$id='')
	{
		$datacontent['url']='admin/hotspot';
		$datacontent['parameter']=$parameter;
		$datacontent['id']=$id;
		$datacontent['title']='Form Hotpost';
		$data['content']=$this->load->view('admin/hotspot/formView',$datacontent,TRUE);
		$data['js']=$this->load->view('admin/hotspot/js/formJs',$datacontent,TRUE);
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
			if($this->input->post('nama')==''){
				$validation[]='Nama Tidak Boleh Kosong';
			}
			if($this->input->post('id_kecamatan')==''){
				$validation[]='Kecamatan Tidak Boleh Kosong';
			}
			if($this->input->post('struktur')==''){
				$validation[]='Struktur Tidak Boleh Kosong';
			}
			if($this->input->post('jumlah_pintu')==''){
				$validation[]='Jumlah Pintu Tidak Boleh Kosong';
			} elseif (!is_numeric($this->input->post('jumlah_pintu'))) {
				$validation[]='Jumlah Pintu Harus Berupa Angka';
			}
			if($this->input->post('dimensi')==''){
				$validation[]='Dimensi Tidak Boleh Kosong';
			}
			if($this->input->post('jenis_pintu')==''){
				$validation[]='Jenis Tidak Boleh Kosong';
			}
			if($this->input->post('lat')==''){
				$validation[]='Titik Koordinat Tidak Boleh Kosong';
			}
			if($this->input->post('lng')==''){
				$validation[]='Titik Koordinat Tidak Boleh Kosong';
			}
			if($this->input->post('id_kategori_bendung')==''){
				$validation[]='Kategori Tidak Boleh Kosong';
			}


			if(count($validation)>0){
				$this->session->set_flashdata('error_validation',$validation);
				$this->session->set_flashdata('error_value',$_POST);
				redirect($_SERVER['HTTP_REFERER']);
				return false;
			}
			// cek validasi

			$data=[
				'id_kecamatan'=>$this->input->post('id_kecamatan'),
				'id_kategori_bendung'=>$this->input->post('id_kategori_bendung'),
				'dimensi'=>$this->input->post('dimensi'),
				'nama'=>$this->input->post('nama'),
				'struktur'=>$this->input->post('struktur'),
				'jumlah_pintu'=>$this->input->post('jumlah_pintu'),
				'jenis_pintu'=>$this->input->post('jenis_pintu'),
				'lat'=>$this->input->post('lat'),
				'lng'=>$this->input->post('lng'),
				'polygon'=>$this->input->post('polygon'),
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
					redirect('admin/hotspot');
					exit();
				}
			}
			// upload
			
			if($_POST['parameter']=="tambah"){
				$this->Model->insert($data);
			}
			else{
				$this->Model->update($data,['id_bendung'=>$this->input->post('id_bendung')]);
			}

		}
		redirect('admin/hotspot');
	}

	public function export($jenis='pdf'){
		if($jenis=='pdf'){
			$datacontent['title']='Hotspot Report';
			$datacontent['datatable']=$this->Model->get();
			$html=$this->load->view('admin/hotspot/pdfView',$datacontent,TRUE);
			generatePdf($html,'Data Bendung/Pintu Air','A4','landscape');
		}
	}

	public function hapus($id=''){
		// hapus file di dalam folder
		$this->db->where('id_bendung',$id);
		$get=$this->Model->get()->row();
		$geojson_hotspot=$get->geojson_hotspot;
		unlink('assets/unggah/geojson/'.$geojson_hotspot);
		// end hapus file di dalam folder
		$this->Model->delete(["id_bendung"=>$id]);
		redirect('admin/hotspot');
	}


	public function datatable(){
		header('Content-Type: application/json');
		$url = 'admin/hotspot';
		$kolom =['id_bendung','nama','nm_kecamatan','struktur','jumlah_pintu','dimensi','jenis_pintu','lat','lng','nm_kategori_bendung'];

		if ( $this->input->get('sSearch')){
			$this->db->group_start();
			for ( $i=0 ; $i<count($kolom) ; $i++ )
			{
		    	$this->db->or_like($kolom[$i],$this->input->get('sSearch',TRUE));
			}
			$this->db->group_end();
		}
		//order
		if ( $this->input->get('iSortCol_0') ){
			for ( $i=0 ; $i<intval( $this->input->get('iSortingCols',TRUE) ) ; $i++ )
			{
			    if ( $this->input->get( 'bSortable_'.intval($_GET['iSortCol_'.$i]),TRUE) == "true" )
			    {
			        $this->db->order_by($kolom[intval( $this->input->get('iSortCol_'.$i,TRUE))],$this->input->get('sSortDir_'.$i,TRUE) );
			    }
			}
		}

      	if($this->input->get('iDisplayLength',TRUE)!="-1"){
	        $this->db->limit($this->input->get('iDisplayLength',TRUE),$this->input->get('iDisplayStart'));
		}

		$dataTable = $this->Model->get();
		$iTotalDisplayRecords=$this->Model->get()->num_rows();
		$iTotalRecords=$dataTable->num_rows();
		$output = [
		  "sEcho" => intval($this->input->get('sEcho')),
		  "iTotalRecords" => $iTotalRecords,
		  "iTotalDisplayRecords" => $iTotalDisplayRecords,
		  "aaData" => array()
		];
		$no=1;
		foreach ($dataTable->result() as $row) {
			$r = null;
			$r[] = $no++;
			$r[] = $row->nama;
			$r[] = $row->nm_kecamatan;
			$r[] = $row->struktur;
			$r[] = $row->jumlah_pintu;
			$r[] = $row->dimensi;
			$r[] = $row->jenis_pintu;
			$r[] = $row->lat;
			$r[] = $row->lng;
			$r[] = $row->nm_kategori_bendung;
			$r[] = '<div class="btn-group">
								<a href="'.site_url($url.'/form/ubah/'.$row->id_bendung).'" class="btn btn-info"><i class="fa fa-edit"></i> Ubah</a>
								<a href="'.site_url($url.'/hapus/'.$row->id_bendung).'" class="btn btn-danger" onclick="return confirm(\'Hapus data?\')"><i class="fa fa-trash"></i> Hapus</a>
							</div>';
			$output['aaData'][] = $r;				
		}
		echo json_encode($output,JSON_PRETTY_PRINT);

	}
/**
	<tbody>
		<?php
			$no=1;
			foreach ($datatable->result() as $row) {
				?>
					<tr>
						<td class="text-center"><?=$no?></td>
						<td><?=$row->nama?></td>
						<td><?=$row->nm_kecamatan?></td>
						<td><?=$row->dimensi?></td>
						<td><?=$row->lat?></td>
						<td><?=$row->lng?></td>
						<td><?=$row->tanggal?></td>
						<td><?=$row->nm_kategori_bendung?></td>
						<td class="text-center">
							<div class="btn-group">
								<a href="<?=site_url($url.'/form/ubah/'.$row->id_bendung)?>" class="btn btn-info"><i class="fa fa-edit"></i> Ubah</a>
								<a href="<?=site_url($url.'/hapus/'.$row->id_bendung)?>" class="btn btn-danger" onclick="return confirm('Hapus data?')"><i class="fa fa-trash"></i> Hapus</a>
							</div>
						</td>
					</tr>
				<?php
				$no++;
			}

		?>
	</tbody>
	**/
}
