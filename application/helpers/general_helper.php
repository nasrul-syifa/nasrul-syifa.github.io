<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$component="backoffice/component/";


if ( ! function_exists('strSubstring')) {
    function strSubstring($col,$max=15)
    {
        return strlen($col)>$max?substr($col,0,$max).'. .':$col;
    }
}
if ( ! function_exists('strFind')) {
    function strFind($search,$data)
    {
        return preg_match("/{$search}/i", $data);
    }
}
if ( ! function_exists('getTags')) {
    function getTags($table,$column)
    {
        $ci=& get_instance();
        $query = $ci->M_crud->read_data($table,$column);
        $tags=[];
        foreach ($query as $row){
            foreach (json_decode($row[$column],true) as $val){
                $tags[]=$val['value'];
            }
        }
        return $tags;
    }
}
if ( ! function_exists('handleOr'))
{
    function handleOr($data,$any)
    {
        $output="";
        if($data!=null)foreach ($data as $val){$output.=" OR ".$val." LIKE '%".$any."%'";}
        return $output;
    }
}

if ( ! function_exists('_slug'))
{
    function _slug($vars)
    {
        return url_title(_post($vars),'dash',true);
    }
}

if ( ! function_exists('form')) {
    function form($selector,$folder,$modalScreen=null){
        return view("backoffice/component/modalForm",['selector'=>$selector,'form'=>$folder."/form","modalScreen"=>$modalScreen]);
//        return view("backoffice/pages/".$folder."/form");

    }
}
if ( ! function_exists('buttonForm')) {
    function buttonForm(){
        return view("backoffice/component/buttonForm");
    }
}
if ( ! function_exists('backoffice/component/statusForm')) {
    function statusForm(){
        return view("backoffice/component/statusForm");
    }
}
if ( ! function_exists('backoffice/component/inputImage')) {
    function inputImage($vars){
        return view("backoffice/component/inputImage",$vars);
    }
}
if ( ! function_exists('inputForm')) {
    function inputForm($vars=array()){
        return view("backoffice/component/inputForm",$vars);
    }
}
if ( ! function_exists('inputQuill')) {
    function inputQuill($vars=array()){
        return view("backoffice/component/inputQuill",$vars);
    }
}
if ( ! function_exists('inputSelect')) {
    function inputSelect($vars){
        return view("backoffice/component/inputSelect",$vars);
    }
}
if ( ! function_exists('inputSelectMultiple')) {
    function inputSelectMultiple($vars){
        return view("backoffice/component/inputSelectMultiple",$vars);
    }
}
if ( ! function_exists('inputTag')) {
    function inputTag($vars=array()){
        return view("backoffice/component/inputTag",$vars);
    }
}
if ( ! function_exists('viewFo'))
{
    function viewFo($vars=array())
    {
        $ci=& get_instance();
        return $ci->load->view("frontoffice/layout/index",$vars);
    }
}

if ( ! function_exists('view'))
{
    function view($path,$vars=array())
    {
        $ci=& get_instance();
        return $ci->load->view($path,$vars);
    }
}
if ( ! function_exists('_rplc'))
{
    function _rplc($replace,$jadi,$name)
    {
        return str_replace($replace,$jadi,$name);
    }
}
if ( ! function_exists('_post'))
{
    function _post($name,$isTrue=true)
    {
        $ci=& get_instance();
        return $ci->input->post($name,$isTrue);
    }
}
if ( ! function_exists('_get'))
{
    function _get($name)
    {
        $ci=& get_instance();
        return $ci->input->get($name,true);
    }
}
if ( ! function_exists('existColumn'))
{
    // return array("col","table","action")
    function existColumn($data=array())
    {
        $ci=& get_instance();
        $judul=_post($data['col']);
        $where = $data['col']."='" . $judul . "'";
        _post($data['action']) == 'edit'? ($where .= " AND ".$data['col']." <>'" . $judul . "'") : null;
        $isExist = $ci->M_crud->get_data($data['table'],$data['col'],$where);
        return $isExist == null ? 'true' : 'false';
    }
}
if ( ! function_exists('getData'))
{
    function getData($table,$where,$column='id desc',$perPage=10)
    {
        $ci=& get_instance();
        $split=explode(" ",$column);
        $col=$split[0];
        $order=$split[1];
        $pagin = pagin($table,$col,$where,$perPage);
        $read_data = $ci->M_crud->read_data($table,'*',$where,$col.' '.$order,null,$pagin['perPage'],$pagin['start']);
        return ['pagin'=>$pagin,'data'=>$read_data];
    }
}
if ( ! function_exists('createData'))
{
    function createData($table,$data,$post)
    {
        $ci=& get_instance();
        $ci->db->trans_begin();
        $response=[];
        if ($post['param'] == 'add') {
            $ci->M_crud->create_data($table,$data);
        } else {
            $ci->M_crud->update_data($table,$data,"id='" . $post['id'] . "'");
        }
        if ($ci->db->trans_status() === false) {
            $ci->db->trans_rollback();
            $response['status'] = false;
        } else {
            $ci->db->trans_commit();
            $response['status'] = true;
        }
        return $response;
    }
}
if ( ! function_exists('editData'))
{
    function editData($table,$id,$col='id')
    {
        $ci=& get_instance();
        $get_data = $ci->M_crud->get_data($table,'*',"$col='" . $id . "'");
        $result = [];
        if ($get_data != null) {
            $result['status'] = true;
            $result['res_data'] = $get_data;

        } else {
            $result['status'] = false;
        }

        return $result;
    }
}
if ( ! function_exists('getTable'))
{
    function getTable($table='',$where='',$td=array(),$isAction=true,$txtStatus='')
    {
        $ci=& get_instance();
        $data=getData($table,$where);
        $output = '';
        $no=$data['pagin']['start'];
        if($data['data'] != null){
            foreach ($data['data'] as $val){
                $no++;
                $status='';
                $nilai = isset ($val['status']) ? $val['status']:null;
                if($nilai!=null){
                    $status.=status($nilai,$txtStatus);
                }
                $action='';
                if($isAction){
                    $action.=/** @lang text */'<td width="1%" class="text-center">
                        <button onclick="edit(\'' .$val['id'] .'\')" class="btn btn-xs btn-primary"><i class="ion ion-compose"></i></button>
                        <button onclick="hapus(\'' .$val['id'] .'\')" class="btn btn-xs btn-primary"><i class="ion ion-trash-a"></i></button>
                        '.$status.'
                    </td> 
                    ';
                }
                $output.=/** @lang text */'
                <tr>
                    <td width="1%" class="text-center">'.$no.'</td>
                    '.$action.'';
                foreach($td as $row){
                    $output.=/** @lang text */' <td width="'.$row['width'].'">'.$val[$row['title']].'</td>';
                }
                $output.=/** @lang text */'</tr>';
            }
        }
        else{
            $output.=/** @lang text */'<tr><td colspan="30">Data tidak tersedia</td></tr>';
        }
        $result = [
            'pagination_link' => $data['pagin']['pagination_link'],
            'result_table' => $output,
        ];
        return $result;
    }
}
if ( ! function_exists('pagin'))
{
    function pagin($table, $field, $where, $page,$uri=4)
    {
        $ci=& get_instance();
        $count = $ci->M_crud->count_data($table, $field, $where);
        $config = [];
        $config['base_url'] = 'javascript:void(0)';
        $config['total_rows'] = $count;
        $config['per_page'] = $page;
        $config['uri_segment'] = $uri;
        $config['num_links'] = 1;
        $config['use_page_numbers'] = true;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&laquo;';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = '&raquo;';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='active'><a href='javascript:void(0)'>";
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $ci->pagination->initialize($config);
        $hal = $ci->uri->segment($uri);
        return $data = [
            'totalRows'=>$config['total_rows'],
            'start' => ($hal - 1) * $config['per_page'],
            'perPage' => $config['per_page'],
            'pagination_link' => $ci->pagination->create_links(),
        ];
    }
}
if ( ! function_exists('upload'))
{
    function upload($folder,$post,$fileUpload)
    {
        $files = $fileUpload;
        if($files['name'][0]!=''){
            foreach ($post as $item){if($item!='') unlink($item);}
            $ci=& get_instance();
            $path = 'upload/'.$folder;
            $manipulasi['upload_path']      = './'.$path;
            $manipulasi['allowed_types']	= '*';
            $manipulasi['maintain_ratio']   = true;
            $manipulasi['width']         	= 500;
            $manipulasi['max_size'] 		= 5120;
            $manipulasi['encrypt_name']     = TRUE;
            $ci->load->library('upload', $manipulasi);
            $arrayImg=array();
            for ($i = 0; $i < count($files['name']); $i++) {
                $_FILES['image']['name'] = $files['name'][$i];
                $_FILES['image']['type'] = $files['type'][$i];
                $_FILES['image']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['image']['error'] = $files['error'][$i];
                $_FILES['image']['size'] = $files['size'][$i];
                $ci->upload->do_upload('image');
                $arrayImg[$i] = $path.'/'.$ci->upload->file_name;
            }
            return implode(',', $arrayImg);
        }
        else{
            return $files['name'][0];
        }
    }
}
if ( ! function_exists('status'))
{
    function status($col,$msg='',$icon='close')
    {
        if ($col == 1) {
            $msg=$msg==''?'Aktif':$msg;
            return '<span class="badge bg-label-success  me-1">'.$msg.'</span>';
        } else {
            $msg=$msg==''?'Tidak Aktif':$msg;
            return '<span class="badge bg-label-warning  me-1">'.$msg.'</span>';
        }
    }
}
if ( ! function_exists('rating'))
{
    function rating($val,$icon='')
    {
        $rating='';
        $no=0;
        for($i=0;$i<(int)$val;$i++){ 
            $no++;
            if($icon!=''){
                $rating.='<i class="bi bi-star-fill"></i>';
            }
            else{
                $rating.='<i class="fa fa-star fa-fw" style="color:#FF912C"></i>';
            }
        }
        if($no < 5){
            for($i=0;$i<(5-$no);$i++){
                if($icon!=''){
                    $rating.='<i class="bi bi-star"></i>';
                }
                else{
                    $rating.='<i class="fa fa-star fa-fw"></i>';
                }
            }
        }
        return $rating;
    }
}
if ( ! function_exists('decodeVariant'))
{
    function decodeVariant($val,$table)
    {
        $ci=& get_instance();
        $pushData=array();
        $val=json_decode($val,true);
        if($val!=null){
            if(count($val) > 0){
                foreach ($val as $row){
                    $getData=$ci->M_crud->read_data($table,"*","id='".$row."'");
                    foreach ($getData as $val){
                        array_push($pushData,$val);
                    }
                }
            }
        }

        return $pushData;
    }
}
if ( ! function_exists('isEmpty'))
{
    function isEmpty($val)
    {
        return $val==""||$val==null||$val=="-";
    }
}

if ( ! function_exists('tglIndo')) {
    function tglIndo($tanggal,$tipe="full",$singkat=""){
        date_default_timezone_set('Asia/Jakarta');
        $arrayHari   = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
        $arrayBulan  = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

        $hari   = date("w",strtotime($tanggal));
        $bulan = $arrayBulan[(int)substr($tanggal,5,2)-1];
        $tahun  = substr($tanggal,0,4);
        $tgl    = substr($tanggal,8,2);
        $waktu  = substr($tanggal,11,5);

        $hasil = $arrayHari[$hari].", ".$tgl." ".$bulan." ".$tahun." ".$waktu;

        if($singkat!="")$bulan = substr($bulan,0,3);
        if($tipe=="month-year") $hasil = $bulan." ".$tahun;

        return $hasil;
    }
}