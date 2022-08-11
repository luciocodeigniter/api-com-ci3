<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PrinterModel extends CI_Model
{
    private $table = 'printers';
    private $returnType = Printer::class;

    public function __construct()
    {
        // load the necessary classes
        $this->load->database();
    }

    /**
     * Retrieve all object from the database
     *
     * @return array
     */
    public function findAll():array
    {
        return $this->db->get($this->table)->result($this->returnType);
    }

    /**
     * Retrieve the object from the database
     *
     * @param array $where
     * @return null|Printer
     */
    public function getWhere(array $where)
    {
        return $this->db->where($where)->limit(1)->get($this->table)->custom_row_object(0, $this->returnType);
    }

    /**
     * Create the printer in the database
     *
     * @param Printer $printer
     * @return integer
     */
    public function create(Printer $printer) : int
    {

        try {

            $this->db->insert($this->table, $printer->toArray());

            return  $this->db->insert_id();
        } catch (\Throwable $th) {

            exit('Internal Server Error');
        }
    }

    /**
     * Update the printer in the database
     *
     * @param Printer $printer
     * @return integer
     */
    public function update(Printer $printer)
    {

        try {

            $printer->setUpdatedAt();

            return $this->db->where('id', $printer->id)->update($this->table, $printer->toArray());
        } catch (\Throwable $th) {

            exit('Internal Server Error');
        }
    }

    /**
     * Remove the printer from the database
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id){

        try {

            return $this->db->where('id', $id)->delete($this->table);
        } catch (\Throwable $th) {

            exit('Internal Server Error');
        }
    }
}
