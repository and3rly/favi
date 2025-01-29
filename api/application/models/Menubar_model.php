<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Menubar_model extends General_model {

	public function buscar($args = [])
	{
        $menuItems =  [];

		if (elemento($args, 'usuario_id')) {
			$this->db->where('ru.usuario_id', $args['usuario_id']);
		}

		$tmp = $this->db
					->select("m.*")
					->join("menu_rol mr","mr.menu_id = m.id", "inner")
					->join("rol r","r.id = mr.rol_id", "inner")
					->join("rol_usuario ru", "ru.rol_id = r.id", "inner")
					->where("m.activo", 1)
					->where("mr.activo", 1)
					->where("ru.usuario_id", 1)
					->get("menu m");

		$result = $tmp->result();

		foreach ($result as $fila) {
            $items = [
                "id" => $fila->id,
                "url" => $fila->ruta,
                "icon" => !empty($fila->icono) ? $fila->icono : 'fa fa-home',
                "text" => $fila->titulo,
                "level" => $fila->nivel,
                "father" => $fila->padre
            ];

            array_push($menuItems, $items);
		}

		echo "<pre>";
		print_r ($menuItems);
		echo "</pre>";
        return json_encode($menuItems);
	}
}

/* End of file Menubar_model.php */
/* Location: ./application/models/Menubar_model.php */