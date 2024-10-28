<?php

namespace App\Livewire;

use App\Models\Device;
use Livewire\Component;

class Devices extends Component
{
    public $device_id;
    public $device_name;
    public $created_at;
    public $updated_at;
    public $status;
    public $searchTerm = '';
    public $new_device;

    protected $rules = [
        'device_name' => 'required|min:2|max:30',
        'new_device' => 'required|min:2|max:30',
    ];

    public function render()
    {
        $devices = Device::where('device_name', 'like', '%' . $this->searchTerm . '%')->get();

        return view('livewire.devices', [
            'devices' => $devices,
        ]);
    }

    public function search()
    {
        $this->render();
    }

    public function display($id)
    {
        $device = Device::findOrFail($id);
        $this->device_id = $device->id;
        $this->device_name = $device->device_name;
        $this->created_at = $device->created_at;
        $this->updated_at = $device->updated_at;
        $this->status = $device->status;
    }

    public function create()
    {
        $this->validateOnly('new_device');

        try {
            Device::create([
                'device_name' => $this->new_device,
            ]);
            session()->flash('type', 'success');
            session()->flash('message', 'Device created successfully!');
        } catch (\Exception $ex) {
            session()->flash('type', 'danger');
            session()->flash('message', 'Something went wrong!');
        }
    }

    public function update()
    {
        if (!$this->device_id) {
            session()->flash('type', 'warning');
            session()->flash('message', 'No device selected.');
            return;
        }

        $this->validateOnly('device_name');

        try {
            $device = Device::findOrFail($this->device_id);
            $device->device_name = $this->device_name;
            $device->save();

            session()->flash('type', 'success');
            session()->flash('message', 'Device updated successfully.');
            $this->clear();
        } catch (\Exception $e) {
            session()->flash('type', 'danger');
            session()->flash('message', "Something went wrong!");
        }
    }

    public function delete()
    {
        if (!$this->device_id) {
            session()->flash('type', 'warning');
            session()->flash('message', 'No device selected to delete.');
            return;
        }

        try {
            Device::findOrFail($this->device_id)->delete();
            session()->flash('type', 'success');
            session()->flash('message', "Device deleted successfully!");
            $this->clear();
        } catch (\Exception $e) {
            session()->flash('type', 'danger');
            session()->flash('message', "Cannot delete this device");
        }
    }

    public function clear()
    {
        $this->reset(['device_id', 'device_name', 'created_at', 'updated_at', 'status']);
    }

    public function toggleStatus()
    {
        if (!$this->device_id) {
            session()->flash('type', 'warning');
            session()->flash('message', 'Please select a device first.');
            return;
        }

        try {
            $device = Device::findOrFail($this->device_id);
            $device->status = !$device->status;
            $device->save();

            session()->flash('type', 'success');
            session()->flash('message', 'Device status updated.');
        } catch (\Exception $e) {
            session()->flash('type', 'danger');
            session()->flash('message', 'Something went wrong!');
        }

        $this->clear();
    }
}
