<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

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

	function cliente()
	{
		$data_action = $this->input->post('data_action');

		switch($data_action){
			case 'Buscar_um':
				if($this->input->post('usuario_id'))
				{
					$data = $this->api_model->fetch_single_user($this->input->post('usuario_id'));
					foreach($data as $row)
					{
						$output['id'] = $row['id'];
						$output['nome'] = $row['nome'];
						$output['cpf'] = $row['cpf'];
						$output['telefone'] = $row['telefone'];
						$output['placa_carro'] = $row['placa_carro'];
					}
					echo json_encode($output);
				}
			break;
			case 'Delete':
				if($this->input->post('usuario_id'))
				{
					if($this->api_model->delete_single_user($this->input->post('usuario_id')))
					{
						$array = array(
		
							'success'	=>	true
						);
					}
					else
					{
						$array = array(
							'error'		=>	true
						);
					}
					echo json_encode($array);
				}
			break;
			case 'Listar_todos':
				$data = $this->api_model->fetch_all();
				$data = $data->result_array();

				$output = '';

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
				
				echo $output;
			break;
			case 'Edit':
				$this->form_validation->set_rules('nome', 'Nome', 'required');
				$this->form_validation->set_rules('telefone', 'Telefone', 'required');
				$this->form_validation->set_rules('cpf', 'CPF', 'required');
				$this->form_validation->set_rules('placa_carro', 'Placa', 'required');
		
				if($this->form_validation->run())
				{	
					$data = array(
						'nome'	=>	$this->input->post('nome'),
						'telefone'	=>	$this->input->post('telefone'),
						'cpf'	=>	$this->input->post('cpf'),
						'placa_carro'		=>	$this->input->post('placa_carro')
					);
		
					$this->api_model->update_api($this->input->post('id'), $data);
		
					$array = array(
						'success'		=>	true
					);
				}
				else
				{
					$array = array(
						'error'					=>	true,
						'nome'		=>	form_error('nome'),
						'telefone'		=>	form_error('telefone'),
						'cpf'		=>	form_error('cpf'),
						'placa_carro'		=>	form_error('placa_carro')
					);
				}
				echo json_encode($array);
			break;
			case 'Insert':
	
				$this->form_validation->set_rules('nome', 'Nome', 'required');
				$this->form_validation->set_rules('telefone', 'Telefone', 'required');
				$this->form_validation->set_rules('cpf', 'CPF', 'required');
				$this->form_validation->set_rules('placa_carro', 'Placa', 'required');
				if($this->form_validation->run())
				{
					$data = array(
						'nome'	=>	$this->input->post('nome'),
						'telefone'	=>	$this->input->post('telefone'),
						'cpf'	=>	$this->input->post('cpf'),
						'placa_carro'		=>	$this->input->post('placa_carro')
					);
		
					$this->api_model->insert_api($data);
		
					$array = array(
						'success'		=>	true
					);
				}
				else
				{
					$array = array(
						'error'					=>	true,
						'nome'		=>	form_error('nome'),
						'telefone'		=>	form_error('telefone'),
						'cpf'		=>	form_error('cpf'),
						'placa_carro'		=>	form_error('placa_carro')
					);
				}
				echo json_encode($array);
			break;
		}
		
	}
	

	function pesquisa()
	{
		if($this->input->post('final'))
		{
			$data = $this->api_model->pesquisa($this->input->post('final'));

			foreach($data as $row)
			{
				$output['nome'] = $row['nome'];
				$output['cpf'] = $row['cpf'];
				$output['telefone'] = $row['telefone'];
				$output['placa_carro'] = $row['placa_carro'];
			}

			echo json_encode($output);
		}
	}

}


?>