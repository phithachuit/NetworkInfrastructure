<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogAlertModel;

class DashboardController extends Controller
{
    protected $data = NULL;
    protected $dataFake = '
    []';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->data;
        $data = json_decode($this->dataFake, true);
        $count = [];
        
        foreach ($data as $item) {
            // Process each $item as needed
            // For example, you can log it or prepare it for the view
            // dd($item);
            if ($item['level'] === 'notice') {
                $count['notice'] = ($count['notice'] ?? 0) + 1;
                // array_push($count, $count['traffic']);
            }

            if ($item['level'] === 'warning') {
                $count['warning'] = ($count['warning'] ?? 0) + 1;
            }
            
            if ($item['level'] === 'critical') {
                $count['critical'] = ($count['critical'] ?? 0) + 1;
            }
        }

        return view('dashboard',compact('count', 'data'));
    }

    public function jsonData()
    {
        // $this->data = json_decode($this->dataFake, true);
        // dd(json_decode($this->dataFake, true));

    }

    public function saveLog(Request $request) {
      // dd($request);
      $data = $request->only('severity', 'name', 'eventid');
      LogAlertModel::createOrIgnore($data);
    }

    public function getLogList() {
      return LogAlertModel::select('name')->get()->toArray();
    }

    public function diagnose() {
        $geminiController = new GeminiController;
        $getAllLog = $this->getLogList();

        $test = $geminiController->sendDiagnose($getAllLog);
        // $test = [
        //   [
        //     "name" => 'w'
        //   ],
        //   [
        //     "name" => "a"
        //   ]
        // ];

        // function duyet($test) {
        //   foreach($test as $t) {
        //     if($t['name']){
        //       return $t['name'];
        //     }

        //     duyet($test);
        //   }
        // }

        dd($test);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
