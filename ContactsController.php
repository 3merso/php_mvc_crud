<?php

class ContactsController extends Controller
{
 
    /**
     * Lista os contatos
     */
    public function list()
    {
        $contacts = Contact::all();
        return $this->view('grade', ['contacts' => $contacts]);
    }
 
    /**
     * Mostrar formulario para criar um novo contato
     */
    public function create()
    {
        return $this->view('form');
    }
 
    /**
     * Mostrar formulário para editarm contato
     */
    public function edit($data)
    {
        $id = (int) $data['id'];
        $contact = Contact::find($id);
 
        return $this->view('form', ['contact' => $contact]);
    }
 
    /**
     * Salvar o contato submetido pelo formulário
     */
    public function save()
    {
        $contact           = new Contact;
        $contact->nome     = $this->request->nome;
        $contact->telefone = $this->request->telefone;
        $contact->email    = $this->request->email;

        if ($contact->save()) {
            return $this->list();
        }
    }
 
    /**
     * Atualizar o contato conforme dados submetidos
     */
    public function update($data)
    {
        $id = (int) $data['id'];
        $contact = Contact::find($id);
        $contact->nome = $this->request->nome;
        $contact->telefone = $this->request->telefone;
        $contact->email = $this->request->email;
        $contact->save();
 
        return $this->list();
    }
 
    /**
     * Apagar um contato conforme o id informado
     */
    public function destroy($data)
    {
        $id = (int) $data['id'];
        $contact = Contact::destroy($id);
        return $this->list();
    }
}
