<?php

namespace App\Livewire;

use App\Models\District;
use Livewire\Component;

class Districts extends Component
{
    public $district_id;
    public $district_name;
    public $created_at;
    public $updated_at;
    public $status;
    public $searchTerm = '';
    public $new_district;

    protected $rules = [
        'district_name' => 'required|min:2|max:50',
        'new_district' => 'required|min:2|max:50',
    ];

    public function render()
    {
        $districts = District::where('district_name', 'like', '%' . $this->searchTerm . '%')->get();

        return view('livewire.districts', [
            'districts' => $districts,
        ]);
    }

    public function search()
    {
        $this->render();
    }

    public function display($id)
    {
        $district = District::findOrFail($id);
        $this->district_id = $district->id;
        $this->district_name = $district->district_name;
        $this->created_at = $district->created_at;
        $this->updated_at = $district->updated_at;
        $this->status = $district->status;
    }

    public function create()
    {
        $this->validateOnly('new_district');

        try {
            District::create([
                'district_name' => $this->new_district,
            ]);
            session()->flash('type', 'success');
            session()->flash('message', 'District created successfully!');
        } catch (\Exception $ex) {
            session()->flash('type', 'danger');
            session()->flash('message', 'Something went wrong!');
        }
    }

    public function update()
    {
        if (!$this->district_id) {
            session()->flash('type', 'warning');
            session()->flash('message', 'No district selected.');
            return;
        }

        $this->validateOnly('district_name');

        try {
            $district = District::findOrFail($this->district_id);
            $district->district_name = $this->district_name;
            $district->save();

            session()->flash('type', 'success');
            session()->flash('message', 'District updated successfully.');
            $this->clear();
        } catch (\Exception $e) {
            session()->flash('type', 'danger');
            session()->flash('message', "Something went wrong!");
        }
    }

    public function delete()
    {
        if (!$this->district_id) {
            session()->flash('type', 'warning');
            session()->flash('message', 'No district selected to delete.');
            return;
        }

        try {
            District::findOrFail($this->district_id)->delete();
            session()->flash('type', 'success');
            session()->flash('message', "District deleted successfully!");
            $this->clear();
        } catch (\Exception $e) {
            session()->flash('type', 'danger');
            session()->flash('message', "Cannot delete this district");
        }
    }

    public function clear()
    {
        $this->reset(['district_id', 'district_name', 'created_at', 'updated_at', 'status']);
    }

    public function toggleStatus()
    {
        if (!$this->district_id) {
            session()->flash('type', 'warning');
            session()->flash('message', 'Please select a district first.');
            return;
        }

        try {
            $district = District::findOrFail($this->district_id);
            $district->status = !$district->status;
            $district->save();

            session()->flash('type', 'success');
            session()->flash('message', 'District status updated.');
        } catch (\Exception $e) {
            session()->flash('type', 'danger');
            session()->flash('message', 'Something went wrong!');
        }

        $this->clear();
    }
}
