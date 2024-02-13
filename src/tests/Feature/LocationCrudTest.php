<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Location;

class LocationCrudTest extends TestCase
{
  
    
      
 
        public function test_store()
        {
            $locationData = [
                'name' => 'istanbul',
                'latitude' => 123.456,
                'longitude' => -78.90,
                'color'=>'blue'
            ];
    
            $response = $this->postJson('/api/locations', $locationData);
    
            $response->assertStatus(201)->assertJsonFragment(['status' => 'successful']);
    
           
        }
    
        /**
         * Test updating a location.
         *
         * @return void
         */
        public function test_update()
        {
            $location = Location::factory()->create();
    
            $updateData = [
                'name' => 'istanbul',
                'latitude' => 123.456,
                'longitude' => -78.90,
                'color'=>'blue'
            ];
    
            $response = $this->putJson('/api/locations/'.$location->id, $updateData);
    
            $response->assertStatus(200)->assertJsonFragment(['status' => 'successful']);
 
        }
    
    
        public function test_show()
        {
            $location = Location::factory()->create();
    
            $response = $this->get('/api/locations/'.$location->id);
    
            $response->assertStatus(200)->assertJsonFragment(['status' => 'successful']);

        }
    
 
        public function test_delete()
        {
            $location = Location::factory()->create();
    
            $response = $this->delete('/api/locations/'.$location->id);
    
            $response->assertStatus(200)->assertJsonFragment(['status' => 'successful']);
 
        }
    
}
