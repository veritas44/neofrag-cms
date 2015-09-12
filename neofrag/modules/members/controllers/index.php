<?php if (!defined('NEOFRAG_CMS')) exit;
/**************************************************************************
Copyright © 2015 Michaël BILCOT & Jérémy VALENTIN

This file is part of NeoFrag.

NeoFrag is free software: you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

NeoFrag is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public License
along with NeoFrag. If not, see <http://www.gnu.org/licenses/>.
**************************************************************************/

class m_members_c_index extends Controller_Module
{
	public function index($members)
	{
		$this	->title('Liste des membres')
				->load->library('table')
				->add_columns(array(
					array(
						'content' => function($data){
							return '<img class="img-avatar-members" style="max-height: 40px; max-width: 40px;" src="'.NeoFrag::loader()->user->avatar($data['avatar'], $data['sex']).'" title="'.$data['username'].'" alt="" />';
						},
						'size'    => TRUE
					),
					array(
						'title'   => 'Membre',
						'content' => function($data){
							return '<div>'.NeoFrag::loader()->user->link($data['user_id'], $data['username']).'</div><small>'.icon('fa-circle '.($data['online'] ? 'text-green' : 'text-gray')).' '.($data['admin'] ? 'Admin' : 'Membre').' '.($data['online'] ? 'en ligne' : 'hors ligne').'</small>';
						},
						'search'  => function($data){
							return $data['username'];
						}
					)/*,
					array(
						//TODO link compose
						'content' => '<?php echo $this->user() ? \'<a href="'.url('user/compose.html').'">'.icon('fa-envelope-o').' Contacter</a>\' : \'\' ?>',
						'size'    => TRUE,
						'align'   => 'right'
					)*/
				))
				->data($members)
				->no_data('Il n\'y a pas encore de membre dans ce groupe');
			
		return new Panel(array(
			'title'   => 'Liste des membres',
			'icon'    => 'fa-users',
			'content' => $this->table->display()
		));
	}

	public function _member($user_id, $username)
	{
		$this->title($username);
		
		return array(
			new Panel(array(
				'title'   => $username,
				'icon'    => 'fa-user',
				'content' => $this->load->view('profile', $this->model()->get_member_profile($user_id)),
			)),
			new Button_back('members.html')
		);
	}
	
	public function _group($title, $members)
	{
		$output = array($this->index($members));
		
		array_unshift($output, new Panel(array(
			'content' => '<h2 class="no-margin">Groupe <small>'.$title.'</small>'.button('members.html', 'fa-close', 'Voir tous les membres', 'danger', 'pull-right').'</h2>'
		)));

		return $output;
	}
}

/*
NeoFrag Alpha 0.1
./neofrag/modules/members/controllers/index.php
*/