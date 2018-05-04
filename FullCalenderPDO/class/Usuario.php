<?php

class Usuario {

    private $idusuario;
    private $deslogin;
    private $dessenha;
    private $dataCadastro;

    public function getIdusuario()
    {
        return $this->idusuario;
    }

    public function setIdusuario($idusuario)
    {
        $this->idusuario = $idusuario;
    }

    public function getDeslogin()
    {
        return $this->deslogin;
    }

    public function setDeslogin($deslogin)
    {
        $this->deslogin = $deslogin;
    }

    public function getDessenha()
    {
        return $this->dessenha;
    }

    public function setDessenha($dessenha)
    {
        $this->dessenha = $dessenha;
    }

    public function getDataCadastro()
    {
        return $this->dataCadastro;
    }

    public function setDataCadastro($dataCadastro)
    {
        $this->dataCadastro = $dataCadastro;    
    }

    /* busca um usuário pelo ID */ 
    public function loadById($id)
    {
        $sql = new Sql();
        $result = $sql->select("SELECT * FROM tb_usuario WHERE idusuario = :ID", array(
            ":ID"=>$id
        ));

        if(count($result) > 0){
            $row = $result[0];
            $this->setIdusuario($row['idusuario']);
            $this->setDeslogin($row['deslogin']);
            $this->setDessenha($row['dessenha']);
            $this->setDataCadastro(new DateTime($row['dataCadastro']));
        }   
    }

    /* lista todos os usuários da tabela ordenado pelo login */
    public static function getList()
    {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_usuario ORDER BY deslogin");
    }

    /* busca um usuário pelo login */
    public function search($login)
    {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_usuario WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
            ":SEARCH"=>"%".$login."%"
        ));
    }

    /* busca em usuário autenticado */
    public function Auth($login, $password)
    {
        $sql = new Sql();
        $result = $sql->select("SELECT * FROM tb_usuario WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(
            ":LOGIN"=>$login,
            ":PASSWORD"=>$password
        ));

        if(count($result) > 0){
            $row = $result[0];
            $this->setIdusuario($row['idusuario']);
            $this->setDeslogin($row['deslogin']);
            $this->setDessenha($row['dessenha']);
            $this->setDataCadastro(new DateTime($row['dataCadastro']));
        }else{
            throw new Exception("Login ou Senha inválidos",1);
        }  
    }

    /* inseri um dado, fizemos o uso de procedure */ 
    public function insert()
    {
        $sql = new Sql();
        $result = $sql->select("CALL sp_usuario_insert(:LOGIN, :PASSWORD)", array(
            ":LOGIN"=>$this->getDeslogin(),
            ":PASSWORD"=>$this->getDessenha()
        ));

        if(count($result) > 0){
            $row = $result[0];
            $this->setIdusuario($row['idusuario']);
            $this->setDeslogin($row['deslogin']);
            $this->setDessenha($row['dessenha']);
            $this->setDataCadastro(new DateTime($row['dataCadastro']));
        }
    }

    /* UPDATE faz a atualização dos dados */
    public function update()
    {
        $sql = new Sql();
        $sql->query("UPDATE tb_usuario SET deslogin = :LOGIN, dessenha = :PASSWORD where idusuario = :ID", array(
            ":LOGIN"=>$this->getDeslogin(),
            ":PASSWORD"=>$this->getDessenha(),
            ":ID"=>$this->getIdusuario()
        ));
    }

    /* DELETE */
    public function delete()
    {
        $sql = new Sql();
        $sql->query("DELETE FROM tb_usuario WHERE idusuario = :ID", array(
            ":ID"=>$this->getIdusuario()
        ));
    }

    /* permite que uma classe decida como se comportar quando convertida para uma string. */
    public function __toString()
    {
        return json_encode(array(
            "idusuario"=>$this->getIdusuario(),
            "deslogin"=>$this->getDeslogin(),
            "dessenha"=>$this->getDessenha(),
            "dataCadastro"=>$this->getDataCadastro()->format("d-m-Y H:i:s")
        ));
    }

}