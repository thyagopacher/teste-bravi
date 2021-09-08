<?php

namespace App\Controllers;

class Person extends BaseController
{
    public function index()
    {
        return view('list_person');
    }

    public function create()
    {
        try {

            $db = \Config\Database::connect();
            $post = \Config\Services::request()->getPost();

            $db->table('pessoa')->insert($post);
            $id = $db->insertID();

            if ($id > 0) {
                $data = [
                    'status' => true,
                    'mensagem' => 'Contato criado com sucesso',
                    'id' => $id
                ];
            } else {
                $data = [
                    'status' => false,
                    'mensagem' => 'Erro ao criar contato'
                ];
            }
            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function update()
    {
        try {
            $db = \Config\Database::connect();
            $post = \Config\Services::request()->getPost();

            if (!empty($post['nome'])) {
                $update_rows['nome'] = $post['nome'];
            }
            if (!empty($post['telefone'])) {
                $update_rows['telefone'] = $post['telefone'];
            }
            if (!empty($post['email'])) {
                $update_rows['email'] = $post['email'];
            }
            if (!empty($post['whatsapp'])) {
                $update_rows['whatsapp'] = $post['whatsapp'];
            }

            $model = $db->table('pessoa');
            $model->where('id', $post['id']);
            $result = $model->update($update_rows);

            if ($result) {
                $data = [
                    'status' => true,
                    'mensagem' => 'Contato alterado com sucesso'
                ];
            } else {
                $data = [
                    'status' => false,
                    'mensagem' => 'Erro ao alterar Contato'
                ];
            }
            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function get()
    {
        $db = \Config\Database::connect();
        $get = \Config\Services::request()->getGet();
        $sql = "
		SELECT *
		FROM pessoa
		where 1 = 1";
        if (!empty($get['id'])) {
            $sql .= " and id = {$get['id']}";
        }

        $query = $db->query($sql);
        $results = $query->getResultArray();

        $data = [
            'data' => $results
        ];
        return $this->response->setJSON($data);
    }

    public function delete()
    {
        try {
            $db = \Config\Database::connect();
            $post = \Config\Services::request()->getPost();

            $model = $db->table('pessoa');
            $result = $model->delete(['id' => $post['id']]);

            if ($result != false) {
                $data = [
                    'status' => true,
                    'mensagem' => 'Contato excluido com sucesso'
                ];
            } else {
                $data = [
                    'status' => false,
                    'mensagem' => 'Erro ao excluir Contato'
                ];
            }
            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function compara_brackets($value = null)
    {
        $post = \Config\Services::request()->getPost();
        if (!empty($post['bracket'])) {
            $value = $post['bracket'];
        }
        $length = strlen($value);
        $ultimoBracket = '';
        $bracketValido = true;
        for ($i = 0; $i < $length; $i++) {
            if (!empty($ultimoBracket)) {
                if ($ultimoBracket == "[" && $value[$i] != "]") {
                    $bracketValido = false;
                } elseif ($ultimoBracket == "{" && $value[$i] != "}") {
                    $bracketValido = false;
                } elseif ($ultimoBracket == "(" && $value[$i] != ")") {
                    $bracketValido = false;
                }
                if (!$bracketValido) {
                    return ($this->response->setJSON(['status' => false, 'mensagem' => 'Bracket inválido']));
                }
            } elseif (in_array($value[0], array("]", "}", ")"))) {
                return ($this->response->setJSON(['status' => false, 'mensagem' => 'Bracket inicial inválido']));
            }
            $ultimoBracket = $value[$i];
        }
        if (in_array($value[$length - 1], array('{', '[', '('))) {
            $data = [
                'status' => false,
                'mensagem' => 'String de Bracket terminou com caractere que inici e não termina.'
            ];
        } elseif ($length <= 1) {
            $data = [
                'status' => false,
                'mensagem' => 'String de Bracket deve ter tamanho maior que 1.'
            ];
        } else {
            $data = [
                'status' => true,
                'mensagem' => 'Bracket considerado válido.'
            ];
        }
        return $this->response->setJSON($data);
    }
}
