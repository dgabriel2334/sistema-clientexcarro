<?php
class Api_model extends CI_Model
{
	function fetch_all()
	{

		$this->db->order_by('id', 'DESC');
		return $this->db->get('usuario');
	}

	function insert_api($dados)
	{
		$this->db->insert('usuario', $dados);
	}

	function fetch_single_user($usuario_id)
	{
		$this->db->where('id', $usuario_id);
		$query = $this->db->get('usuario');
		return $query->result_array();
	}

	function update_api($usuario_id, $dados)
	{
		$this->db->where('id', $usuario_id);
		$this->db->update('usuario', $dados);
	}

	function delete_single_user($usuario_id)
	{
		$this->db->where('id', $usuario_id);
		$this->db->delete('usuario');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function pesquisa($final_placa)
	{

		$this->db->like('placa_carro', $final_placa, 'before');
		$query = $this->db->get('usuario');
		return $query->result_array();
	}
}

?>