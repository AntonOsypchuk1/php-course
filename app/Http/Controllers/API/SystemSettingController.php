<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\SystemSettingService;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    private SystemSettingService $settings;

    public function __construct(SystemSettingService $settings)
    {
        $this->middleware('auth:api');
        $this->settings = $settings;
    }

    /**
     * GET /api/settings
     */
    public function index()
    {
        // Returns key => value pairs
        return $this->respond($this->settings->all());
    }

    /**
     * PUT /api/settings/{id}
     */
    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'value' => 'required|string',
        ]);

        // Find by ID, then update via service
        $setting = SystemSetting::findOrFail($id);
        $this->settings->set($setting->key, $data['value']);

        return $this->respond([
            'key'   => $setting->key,
            'value' => $data['value'],
        ]);
    }
}
