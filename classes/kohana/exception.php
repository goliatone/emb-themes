<?php defined('SYSPATH') or die('No direct script access.');
/**
 * IN ORDER FOR THIS TO WORK, WE NEED TO PLACE IT INSIDE OUR 
 * APPLICATION>CLASSES directory.
 * 
 */
class Kohana_Exception extends Kohana_Kohana_Exception {
	
    public static function handler(Exception $e)
    {
		
        if (Kohana::DEVELOPMENT === Kohana::$environment)
        { 
            //parent::handler($e);
            die("IN MODULE STRUCTURE");
        }
        else
        { 
            try
            {
                Kohana::$log->add(Log::ERROR, parent::text($e));
 
                $attributes = array
                (
                    'action'  => 500,
                    'message' => rawurlencode($e->getMessage()),
                    'origuri' => rawurlencode(Arr::get($_SERVER, 'REQUEST_URI'))
                );
 
                if ($e instanceof HTTP_Exception)
                {
                    $attributes['action'] = $e->getCode();
                }  
 				
                // Error sub-request.
                echo Request::factory(Route::get('error')->uri($attributes))
                ->execute()
                ->send_headers()
                ->body();
            }
            catch (Exception $e)
            { 
                // Clean the output buffer if one exists
                ob_get_level() and ob_clean();
                // Display the exception text
                echo parent::text($e);
 
                // Exit with an error status
                exit(1);
            }
        }
    }

	/**
    * Override if necessary.  E.g. below include logged in user's info in the log
   */
   public static function text(Exception $e)
   {

    $id = "fuckyou";
    return sprintf('[user: %s] %s [ %s ]: %s ~ %s [ %d ]',
            $id, get_class($e), $e->getCode(), strip_tags($e->getMessage()), Debug::path($e->getFile()), $e->getLine());        

   }
}