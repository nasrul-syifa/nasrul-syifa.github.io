<?php
/**
 * Created by PhpStorm.
 * User: annashrulyusuf
 * Date: 4/8/2022
 * Time: 12:35 AM
 */

class MY_Front extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->output->set_header('Cache-Control: no-store, no-cache, max-age=0, post-check=0, pre-check=0');
        $this->sessionId= $this->session->id;
        $this->modalFullScreen = "modal-fullscreen";
        $this->baseLayoutFo = "frontoffice/layout/index";
        $this->limit    = 5;
        $this->segment  = 5;

        $this->url              = base_url();
        $this->assets           = "assets/bo/";
        $this->noImage          = base_url().'assets/no_image.png';
        $this->avatar           = base_url()."assets/bo/assets/img/avatars/1.png";
        $this->layout           = "backoffice/layout/index";
        $this->folder           = "backoffice/pages/";

        $this->pathSection      = $this->folder."section/";
        $this->pathMasterData   = $this->folder."master-data/";
        $this->pathInformasi    = $this->folder."informasi/";
        $this->pathPengaturan   = $this->folder."pengaturan/";

        $this->component        = "backoffice/component/";
        $this->buttonForm       = $this->component."buttonForm";
        $this->generalHeader    = $this->component."generalHeader";
        $this->statusForm       = $this->component."statusForm";
        $this->inputImage       = $this->component."inputImage";
        $this->paginHtml        = $this->component."paginHtml";


        $this->masterData   = "master-data/";
        $this->informasi    = "informasi";
        $this->section      = "section";
        $this->title        = "title";
        $this->page         = "page";
        $this->index        = "index";
        $this->list         = "list";
        $this->testimoni    = "testimoni";
        $this->partner      = "partner";
        $this->banner       = "banner";
        $this->video       = "video";
        $this->layanan      = "layanan";
        $this->pengaturan   = "pengaturan";
        $this->perusahaan   = "perusahaan";
        $this->pengguna     = "pengguna";
        $this->lokasi       = "lokasi";




        $this->paket            = "paket";
        $this->produk           = "produk";
        $this->jenisInformasi   = "jenis_informasi";
        $this->kategoriInformasi= "kategori_informasi";
        $this->faq              = "faq";
        $this->socmed              = "socmed";
        $this->sejarah              = "sejarah";

        $this->viewInformasi= "view_informasi";
        $this->viewProduk   = "view_produk";
        $this->viewPaket    = "view_paket";
        $this->viewPartner    = "view_partner";

        $this->totalRows    = "totalRows";
        $this->lastRows     = "lastRows";
        $this->currentPages = "currentPages";
        $this->countPerPage = "countPerPage";
        $this->no           = "no";
        $this->pages        = "pages";
        $this->perPage      = "perPage";
        $this->start        = "start";


        $this->id           = "id";
        $this->idModel     = "id_model";
        $this->idKategori  = "id_kategori";
        $this->any          = "any";
        $this->nama         = "nama";
        $this->email         = "email";
        $this->longitude         = "longitude";
        $this->latitude         = "latitude";
        $this->telepon         = "telepon";
        $this->slogan         = "slogan";
        $this->seo         = "seo";
        $this->alamat         = "alamat";
        $this->judul        = "judul";
        $this->deskripsi    = "deskripsi";
        $this->kategori     = "kategori";
        $this->namaKategori     = "nama_kategori";
        $this->namaPartner     = "nama_partner";
        $this->linkPartner     = "link_partner";
        $this->gambarPartner     = "gambar_partner";
        $this->namaModel     = "nama_model";
        $this->jenis        = "jenis";
        $this->gambar       = "gambar";
        $this->status       = "status";
        $this->tags         = "tags";
        $this->harga        = "harga";
        $this->hargaCoret   = "harga_coret";
        $this->slug         = "slug";
        $this->platform     = "platform";
        $this->model        = "model";
        $this->jawaban      = "jawaban";
        $this->pertanyaan   = "pertanyaan";
        $this->daftar   = "daftar";
        $this->link   = "link";
        $this->icon   = "icon";

        $this->varian       = "varian";
        $this->param        = "param";
        $this->fileUploaded = "file_uploaded";
        $this->fileUpload   = "file_upload";
        $this->tanggal   = "tanggal";
        $this->tglBuat   = "Tgl Buat";

        $this->msgNoData = "Data tidak tersedia";
    }
}