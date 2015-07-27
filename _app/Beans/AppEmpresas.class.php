<?php

/**
 * AppEmpresas.class.php [Beans]
 * 
 * Classe que representa a tabela app_empresas do banco de dados
 * 
 * @copyright (c) 2015, Adriano S. Reis Programador
 */
class AppEmpresas extends Beans {

    private $empresa_id;
    private $empresa_title;
    private $empresa_name;
    private $empresa_capa;
    private $empresa_ramo;
    private $empresa_sobre;
    private $empresa_site;
    private $empresa_facebook;
    private $empresa_endereco;
    private $empresa_uf;
    private $empresa_cidade;
    private $empresa_categoria;
    private $empresa_status;
    private $empresa_views;
    private $empresa_date;
    private $empresa_last_view;

    function __construct() {
        $this->Controle = new Controle('app_empresas');
    }
    
    /**
     * 
     * @return Objeto pupulado com todos os dados não nulo setado anteriormente.
     * 
     */
    public function getThis() {
        $this->Controle->setDados(array_filter([
            'empresa_title' => $this->getEmpresa_title(),
            'empresa_name' => $this->getEmpresa_name(),
            'empresa_capa' => $this->getEmpresa_capa(),
            'empresa_ramo' => $this->getEmpresa_ramo(),
            'empresa_sobre' => $this->getEmpresa_sobre(),
            'empresa_site' => $this->getEmpresa_site(),
            'empresa_facebook' => $this->getEmpresa_facebook(),
            'empresa_endereco' => $this->getEmpresa_endereco(),
            'empresa_uf' => $this->getEmpresa_uf(),
            'empresa_cidade' => $this->getEmpresa_cidade(),
            'empresa_categoria' => $this->getEmpresa_categoria(),
            'empresa_status' => $this->getEmpresa_status(),
            'empresa_views' => $this->getEmpresa_views(),
            'empresa_date' => $this->getEmpresa_date(),
            'empresa_last_view' => $this->getEmpresa_last_view(),
            'empresa_id' => $this->getEmpresa_id()
        ]));
        return $this->Controle->getDados();
    }

    /**
     * transforma a stdClass neste objeto, transferindo todos os dados não nulos para esta classe;
     * 
     * @param stdClass $object
     */
    public function setThis($object) {
        $this->setEmpresa_title(( isset($object->empresa_title) ? $object->empresa_title : null));
        $this->setEmpresa_name(( isset($object->empresa_name) ? $object->empresa_name : null));
        $this->setEmpresa_capa(( isset($object->empresa_capa) ? $object->empresa_capa : null));
        $this->setEmpresa_ramo(( isset($object->empresa_ramo) ? $object->empresa_ramo : null));
        $this->setEmpresa_sobre(( isset($object->empresa_sobre) ? $object->empresa_sobre : null));
        $this->setEmpresa_site(( isset($object->empresa_site) ? $object->empresa_site : null));
        $this->setEmpresa_facebook(( isset($object->empresa_facebook) ? $object->empresa_facebook : null));
        $this->setEmpresa_endereco(( isset($object->empresa_endereco) ? $object->empresa_endereco : null));
        $this->setEmpresa_uf(( isset($object->empresa_uf) ? $object->empresa_uf : null));
        $this->setEmpresa_cidade(( isset($object->empresa_cidade) ? $object->empresa_cidade : null));
        $this->setEmpresa_categoria(( isset($object->empresa_categoria) ? $object->empresa_categoria : null));
        $this->setEmpresa_status(( isset($object->empresa_status) ? $object->empresa_status : null));
        $this->setEmpresa_views(( isset($object->empresa_views) ? $object->empresa_views : null));
        $this->setEmpresa_date(( isset($object->empresa_date) ? $object->empresa_date : null));
        $this->setEmpresa_last_view(( isset($object->empresa_last_view) ? $object->empresa_last_view : null));
        $this->setEmpresa_id(( isset($object->empresa_id) ? $object->empresa_id : null));
    }

    /**
     * Retorna operações de insert, update, delete, e buscas
     * 
     * @return Controle
     */
    public function Execute() {
        $this->getThis();
        return $this->Controle;
    }

    /**
     * ****************************************
     * ************** GET & SET ***************
     * ****************************************
     */
    
    function getEmpresa_id() {
        return $this->empresa_id;
    }

    function getEmpresa_title() {
        return $this->empresa_title;
    }

    function getEmpresa_name() {
        return $this->empresa_name;
    }

    function getEmpresa_capa() {
        return $this->empresa_capa;
    }

    function getEmpresa_ramo() {
        return $this->empresa_ramo;
    }

    function getEmpresa_sobre() {
        return $this->empresa_sobre;
    }

    function getEmpresa_site() {
        return $this->empresa_site;
    }

    function getEmpresa_facebook() {
        return $this->empresa_facebook;
    }

    function getEmpresa_endereco() {
        return $this->empresa_endereco;
    }

    function getEmpresa_uf() {
        return $this->empresa_uf;
    }

    function getEmpresa_cidade() {
        return $this->empresa_cidade;
    }

    function getEmpresa_categoria() {
        return $this->empresa_categoria;
    }

    function getEmpresa_status() {
        return $this->empresa_status;
    }

    function getEmpresa_views() {
        return $this->empresa_views;
    }

    function getEmpresa_date() {
        return $this->empresa_date;
    }

    function getEmpresa_last_view() {
        return $this->empresa_last_view;
    }

    function setEmpresa_id($empresa_id) {
        $this->empresa_id = $empresa_id;
    }

    function setEmpresa_title($empresa_title) {
        $this->empresa_title = $empresa_title;
    }

    function setEmpresa_name($empresa_name) {
        $this->empresa_name = $empresa_name;
    }

    function setEmpresa_capa($empresa_capa) {
        $this->empresa_capa = $empresa_capa;
    }

    function setEmpresa_ramo($empresa_ramo) {
        $this->empresa_ramo = $empresa_ramo;
    }

    function setEmpresa_sobre($empresa_sobre) {
        $this->empresa_sobre = $empresa_sobre;
    }

    function setEmpresa_site($empresa_site) {
        $this->empresa_site = $empresa_site;
    }

    function setEmpresa_facebook($empresa_facebook) {
        $this->empresa_facebook = $empresa_facebook;
    }

    function setEmpresa_endereco($empresa_endereco) {
        $this->empresa_endereco = $empresa_endereco;
    }

    function setEmpresa_uf($empresa_uf) {
        $this->empresa_uf = $empresa_uf;
    }

    function setEmpresa_cidade($empresa_cidade) {
        $this->empresa_cidade = $empresa_cidade;
    }

    function setEmpresa_categoria($empresa_categoria) {
        $this->empresa_categoria = $empresa_categoria;
    }

    function setEmpresa_status($empresa_status) {
        $this->empresa_status = $empresa_status;
    }

    function setEmpresa_views($empresa_views) {
        $this->empresa_views = $empresa_views;
    }

    function setEmpresa_date($empresa_date) {
        $this->empresa_date = $empresa_date;
    }

    function setEmpresa_last_view($empresa_last_view) {
        $this->empresa_last_view = $empresa_last_view;
    }

}
