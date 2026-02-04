<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;

class GeneralSettings extends Component
{
    use WithFileUploads;

    public $site_name;
    public $site_logo;
    public $current_logo;
    public $primary_color;
    public $secondary_color;

    public function mount()
    {
        $this->site_name = setting('site_name');
        $this->current_logo = setting('site_logo');
        $this->primary_color = setting('primary_color', '#198754');
        $this->secondary_color = setting('secondary_color', '#20c997');
    }

    public function save()
    {
        setting_save('site_name', $this->site_name);

        if ($this->site_logo) {
            $setting = Setting::firstOrCreate(['key' => 'site_logo']);
            $setting->clearMediaCollection('logo');
            $setting->addMedia($this->site_logo->getRealPath())
                ->usingName('site_logo')
                ->toMediaCollection('logo');
            setting_save('site_logo', $setting->getFirstMediaUrl('logo'));
        }


        setting_save('primary_color', $this->primary_color);
        setting_save('secondary_color', $this->secondary_color);

        session()->flash('success', 'تم حفظ الإعدادات بنجاح');
          return redirect()->route('admin.settings.index');
    }


    public function render()
    {
        return view('admin.settings.general')->layout('layouts.app');
        ;
    }
}
