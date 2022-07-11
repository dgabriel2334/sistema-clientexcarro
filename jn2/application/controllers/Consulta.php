<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consulta extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('api_model');
		$this->load->library('form_validation');
	}

	function index()
	{
		$data = $this->api_model->fetch_all();
		echo json_encode($data->result_array());
	}

	function final_placa()
	{
		$data = $this->api_model->pesquisa($this->input->post('final'));

		$output = '';

		if($this->input->post('final'))
		{

			$data = $this->api_model->pesquisa($this->input->post('final'));
			if(count($data) > 0)
				{
					$i=1;
					foreach($data as $row)
					{
						$output .= '
						<tr>
							<td>'.$i.'</td>
							<td>'.$row['nome'].'</td>
							<td>'.$row['telefone'].'</td>
							<td>'.$row['cpf'].'</td>
							<td>'.$row['placa_carro'].'</td>
							<td><butto type="button" name="edit" class="btn btn-warning btn-xs edit" usuario_id="'.$row['id'].'">Editar</button></td>
							<td><button type="button" name="delete" class="btn btn-danger btn-xs delete" usuario_id="'.$row['id'].'">Deletar</button></td>
						</tr>

						';
						$i++;

					}
				}
				else
				{
					$output .= '
					<tr>
						<td colspan="4" align="center">Nenhum cadastro</td>
					</tr>
					';
				}

		}
		echo json_encode($output);

	}

}


?>