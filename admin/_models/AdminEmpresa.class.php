<?php

/**
 * AdminEmpresa.class.php [ Models Admin ]
 * Responsavel por gerenciar as Empresas do sistema no Admin
 *
 * @copyright (c) 2015 AdrianoReis AdrianoReis Tecnologia
 */
class AdminEmpresa {

    private $Data;
    private $Empresa;
    private $Error;
    private $Result;

    /**
     * <b>Cadastrar a Empresa:</b> Envelope os dados da empresa em um array atribuitivo e execute esse método
     * para cadastrar a mesma no banco.
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeCreate(array $Data) {
        $this->Data = $Data;
        if (in_array('', $this->Data)):
            $this->Error = ["Erro ao Cadastrar: Para cadastrar uma empresa, preencha todos os campos!", WS_ALERT];
            $this->Result = false;
        else:
            $this->setData();
            $this->setName();
            $this->sendCapa();
            $this->Create();
        endif;
    }

    /**
     * <b>Atualizar a Empresa:</b> Envelope os dados em uma array atribuitivo e informe o id de uma empresa
     * para atualiza-la no banco de dados!
     * @param INT $EmpresaId = Id da Empresa
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeUpdate($EmpresaId, array $Data) {
        $this->Empresa = (int) $EmpresaId;
        $this->Data = $Data;
        if (in_array('', $this->Data)):
            $this->Error = ["Erro ao Atualizar: Para atualizar <b>{$this->Data['empresa_title']}</b>, preencha todos os campos!", WS_ALERT];
            $this->Result = false;
        else:
            $this->setData();
            $this->setName();
            $this->sendCapa();
            $this->Update();
        endif;
    }

    /**
     * <b>Deleta Empresas:</b> Informe o ID da empresa a ser removida para que esse método realize uma
     * checagem excluinto todos os dados nessesários e removendo a empresa do banco!
     * @param INT $EmpresaId = Id da empresa!
     */
    public function ExeDelete($EmpresaId) {
        $this->Empresa = (int) $EmpresaId;

        $ReadEmp = new AppEmpresas;
        $ReadEmp->setEmpresa_id($this->Empresa);
        $ReadEmp->Execute()->find();
        if (!$ReadEmp->Execute()->getResult()):
            $this->Error = ["A empresa que você tentou deletar não existe no sistema!", WS_ERROR];
            $this->Result = false;
        else:
            $EmpDelete = $ReadEmp->Execute()->getResult();
            $imagem = '../uploads/' . $EmpDelete->empresa_capa;
            if (file_exists($imagem) && !is_dir($imagem)):
                unlink($imagem);
            endif;

            $ReadEmp->delete();

            $this->Error = ["A empresa <b>{$EmpDelete->empresa_title}</b> foi removida com sucesso do sistema!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

    /**
     * <b>Ativa/Inativa Empresa:</b> Informe o ID da empresa e o status e um status sendo 1 para ativo e 0 para
     * rascunho. Esse méto ativa e inativa as empresas!
     * @param INT $PostId = Id do post
     * @param STRING $PostStatus = 1 para ativo, 0 para inativo
     */
    public function ExeStatus($EmpresaId, $EmpresaStatus) {
        $this->Empresa = (int) $EmpresaId;
        $this->Data['empresa_status'] = (string) $EmpresaStatus;
        $this->Data['empresa_id'] = $this->Empresa;

        $Update = new Controle('app_empresas');

        $Update->update($this->Data, "empresa_id");
    }

    /**
     * <b>Verificar Ação:</b> Retorna TRUE se ação for efetuada ou FALSE se não. Para verificar erros
     * execute um getError();
     * @return BOOL $Var = True or False
     */
    public function getResult() {
        return $this->Result;
    }

    /**
     * <b>Obter Erro:</b> Retorna um array associativo com um erro e um tipo.
     * @return ARRAY $Error = Array associativo com o erro
     */
    public function getError() {
        return $this->Error;
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    //Valida e cria os dados para realizar o cadastro. Realiza Upload da Capa!
    private function setData() {
        $this->Data['empresa_name'] = Check::Name($this->Data['empresa_title']);
        $this->Data['empresa_date'] = date('Y-m-d H:i:s');
    }

    //Verifica o NAME da empresa. Se existir adiciona um pós-fix +1
    private function setName() {
        $Where = (isset($this->Empresa) ? "empresa_id != {$this->Empresa} AND " : "");
        $Read = new AppEmpresas();
        $Read->setEmpresa_title($this->Data['empresa_title']);
        $Read->Execute()->Query("{$Where}#empresa_title#");

        if ($Read->Execute()->getResult()):
            $this->Data['empresa_name'] = $this->Data['empresa_name'] . '-' . $Read->Execute()->getRowCount();
        endif;
    }

    //Verifica e envia a capa da empresa para a pasta!
    private function sendCapa() {
        if (!empty($this->Data['empresa_capa']['tmp_name'])):
            list($w, $h) = getimagesize($this->Data['empresa_capa']['tmp_name']);

            if ($w != '578' || $h != '288'):
                $_SESSION['errCapa'] = ['Capa Inválida: A Capa da empresa deve ter exatamente 578x288px do tipo .JPG, .PNG ou .GIF!', WS_INFOR];
                $this->Result = false;
                $this->Data['empresa_capa'] = null;
            else:
                $this->checkCover();
                $Upload = new Upload;
                $Upload->Image($this->Data['empresa_capa'], $this->Data['empresa_name'], 578, 'empresas');

                if ($Upload->getError()):
                    $this->Error = $Upload->getError();
                    $this->Result = false;
                else:
                    $this->Data['empresa_capa'] = $Upload->getResult();
                    $this->Result = true;
                endif;
            endif;
        endif;
    }

    //Verifica se já existe uma capa, se sim deleta para enviar outra!
    private function checkCover() {
        $readCapa = new AppEmpresas;
        $readCapa->Execute()->FullRead("SELECT empresa_capa FROM app_empresas WHERE empresa_id = :id", "id={$this->Empresa}");
        if ($readCapa->Execute()->getRowCount()):
            $delCapa = $readCapa->Execute()->getRowCount()[0]->empresa_capa;
            $imagem = "../uploads/{$delCapa}";
            if (file_exists($imagem) && !is_dir($imagem)):
                unlink($imagem);
            endif;
        endif;
    }

    //Cadastra a empresa no banco!
    private function Create() {
        $Create = new AppEmpresas;
        $Create->setThis((object) $this->Data);
        $Create->Execute()->insert();
        if ($Create->Execute()->getResult()):
            $this->Result = $Create->Execute()->MaxFild("empresa_id");
            $this->Error = ["A empresa <b>{$this->Data['empresa_title']}</b> foi cadastrada com sucesso no sistema!", WS_ACCEPT];
        endif;
    }

    //Atualiza a empresa no banco!
    private function Update() {
        $Update = new AppEmpresas;
        $this->Data['empresa_capa'] = ( $this->Data['empresa_capa'] != 'null' ? $this->Data['empresa_capa'] : null );
        $Update->setThis((object) $this->Data);
        $Update->setEmpresa_id($this->Empresa);
        $Update->Execute()->update(null, 'empresa_id');
        if ($Update->Execute()->getRowCount() >= 1):
            $this->Error = ["A Empresa <b>{$this->Data['empresa_title']}</b> foi atualizada com sucesso!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

}
