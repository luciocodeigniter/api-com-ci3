<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PrintersController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        // load the necessary libraries
        $this->load->model('printerModel');
        $this->load->library('form_validation');
        $this->load->library('printer');
    }

    /**
     * Recovers all printers from the database
     *
     * @return CI_Output
     */
    public function index()
    {
        $printers = $this->printerModel->findAll();

        $data = [];

        foreach($printers as $printer){

            $data[] = $printer->toArray();
        }

        return $this->respond(statusCode: 200, data: $data);
    }

    /**
     * Returns to the client that the resource was not found
     *
     * @return CI_Output
     */
    public function failNotFound()
    {

        return $this->output
            ->set_status_header(404)
            ->set_content_type('application/json')
            ->set_output(json_encode(['message' => 'Not found']));
    }

    /**
     * Retrieve printer from database according to ID
     *
     * @param integer|null $id
     * @return CI_Output
     */
    public function show(?int $id = null)
    {
        // get the printer
        $printer = $this->printerModel->getWhere(['id' => $id]);

        // check for existence
        if ($printer === null) {

            return $this->failNotFound();
        }

        return $this->respond(statusCode: 200, data: $printer->toArray());
    }

    /**
     * Create the printer in the database
     *
     * @return CI_Output
     */
    public function create()
    {
        // even though we have defined the routes with HTTP verbs, it is good practice to ensure that a certain method is accessed
        // according to the expected verb
        if (strtolower($this->input->method()) !== 'post') {

            return $this->fail('Method not allowed');
        }

        // set rules validations
        $this->setRulesValidations();

        // validates the request
        if (!$this->form_validation->run()) {

            return $this->failValidationError();
        }

        // get the safe input request 
        $safeInputRequest = $this->input->post(xss_clean: true); // XSS Clean

        // create de printers object
        $printer = new Printer(data: $safeInputRequest, defineInitialDates: true);
 
        // store the printer    
        $printer->id = $this->printerModel->create($printer);

        // return 
        return $this->respond(statusCode: 201, data: $printer->toArray(), message: 'Printer successfully created!');
    }

    /**
     * Update printer in database according to ID
     *
     * @param integer|null $id
     * @return CI_Output
     */
    public function update(?int $id = null)
    {

        // even though we have defined the routes with HTTP verbs, it is good practice to ensure that a certain method is accessed
        // according to the expected verb
        if (strtolower($this->input->method()) !== 'put') {

            return $this->fail('Method not allowed');
        }

        // set rules validations
        $this->setRulesValidations('update');

        // validate request
        if (!$this->form_validation->run()) {

            return $this->failValidationError();
        }

        // get the printer
        $printer = $this->printerModel->getWhere(['id' => $id]);

        // check for existence
        if ($printer === null) {

            return $this->failNotFound();
        }

        // input_stream to get  PUT, DELETE, PATCH data request
        $safeInputRequest  = $this->input->input_stream(xss_clean: true); // XSS Clean

        // filling de properties
        $printer->fill($safeInputRequest);

        // update de printer
        $this->printerModel->update($printer);

        return $this->respond(statusCode: 204); // 204 => no content status
    }


    /**
     * Delete printer from database according to ID
     *
     * @param integer|null $id
     * @return CI_Output
     */
    public function delete(?int $id = null)
    {

        // even though we have defined the routes with HTTP verbs, it is good practice to ensure that a certain method is accessed
        // according to the expected verb
        if (strtolower($this->input->method()) !== 'delete') {

            return $this->fail('Method not allowed');
        }

        // get the printer
        $printer = $this->printerModel->getWhere(['id' => $id]);

        // check for existence
        if ($printer === null) {

            return $this->failNotFound();
        }

        // delete de printer
        $this->printerModel->delete($printer->id);

        return $this->respond(statusCode: 204); // 204 => no content status
    }

    /**
     * Send back to the client a proper response success
     *
     * @param integer $statusCode
     * @param mixed $data
     * @param string|null $message
     * @return void
     */
    private function respond(int $statusCode = 200, mixed $data = null, string $message = null)
    {

        $this->output->set_status_header($statusCode);
        $this->output->set_content_type('application/json');

        if($message === null){

            $this->output->set_output(json_encode(['data' => $data]));

        }else{

            $this->output->set_output(json_encode(['data' => $data, 'message' => $message]));
        }
        

        return $this->CI_Output;
            
    }

    /**
     * Send back to the client a proper response with the validation errors
     *
     * @return CI_Output
     */
    private function failValidationError()
    {

        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode(['errors' => $this->form_validation->error_array()]));
    }

    /**
     * Send back to the client a proper response when occurs a bad request
     *
     * @param string $message
     * @return CI_Output
     */
    private function fail(string $message = '')
    {

        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode(['message' => $message]));
    }

    /**
     * Set the validations rules 
     *
     * @param string $action
     * @return void
     */
    private function setRulesValidations(string $action = 'create')
    {

        // common rules
        $this->form_validation->set_rules('location', 'Location', 'required');
        $this->form_validation->set_rules('brand', 'Brand', 'required');
        $this->form_validation->set_rules('model', 'Model', 'required');
        $this->form_validation->set_rules('active', 'Active', 'required|in_list[0,1]');


        if ($action === 'create') {
            $this->form_validation->set_rules('name', 'Name', 'required|is_unique[printers.name]');
        } else {

            // setamos os dados da requisição PUT, já sanitizada
            $this->form_validation->set_data($this->input->input_stream(xss_clean: true));
            $this->form_validation->set_rules(
                'name',
                'Name',
                [
                    'required',
                    [
                        'name_callable',
                        function ($name) {

                            // we get the id from the url
                            $id = $this->uri->segment('3');

                            // get from database
                            $exists = $this->printerModel->getWhere(['id !=' => $id, 'name' => $name]);

                            // check if it was found
                            if ($exists) {
                                $this->form_validation->set_message('name_callable', 'That name already exists.');
                                return false;
                            }

                            // not found, then you can update
                            return true;
                        }
                    ]
                ]
            );
        }
    }
}
