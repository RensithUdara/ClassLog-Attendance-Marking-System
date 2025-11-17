<?php
/**
 * Language Manager Class
 * ClassLog Attendance Marking System
 * 
 * This class handles multi-language support for the application
 */

class LanguageManager {
    private $currentLanguage = 'en';
    private $translations = [];
    private $availableLanguages = [
        'en' => 'English',
        'si' => 'සිංහල',
        'ta' => 'தமிழ்'
    ];
    
    public function __construct($language = 'en') {
        $this->setLanguage($language);
    }
    
    /**
     * Set the current language
     */
    public function setLanguage($language) {
        if (array_key_exists($language, $this->availableLanguages)) {
            $this->currentLanguage = $language;
            $this->loadTranslations();
            
            // Store in session for persistence
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['language'] = $language;
        }
    }
    
    /**
     * Get current language code
     */
    public function getCurrentLanguage() {
        return $this->currentLanguage;
    }
    
    /**
     * Get available languages
     */
    public function getAvailableLanguages() {
        return $this->availableLanguages;
    }
    
    /**
     * Load translations for current language
     */
    private function loadTranslations() {
        $langFile = dirname(__DIR__) . "/lang/{$this->currentLanguage}.php";
        
        if (file_exists($langFile)) {
            $this->translations = include $langFile;
        } else {
            // Fallback to English if language file doesn't exist
            $this->translations = include dirname(__DIR__) . "/lang/en.php";
        }
    }
    
    /**
     * Get translated text
     */
    public function get($key, $default = null) {
        if (isset($this->translations[$key])) {
            return $this->translations[$key];
        }
        
        // Return default or key if translation not found
        return $default !== null ? $default : $key;
    }
    
    /**
     * Translate text with parameters
     */
    public function translate($key, $params = [], $default = null) {
        $text = $this->get($key, $default);
        
        // Replace parameters in text
        if (!empty($params)) {
            foreach ($params as $param => $value) {
                $text = str_replace("{{$param}}", $value, $text);
            }
        }
        
        return $text;
    }
    
    /**
     * Initialize language from session or browser
     */
    public static function initialize() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $language = 'en'; // Default language
        
        // Check session first
        if (isset($_SESSION['language'])) {
            $language = $_SESSION['language'];
        } 
        // Check browser language
        elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            $availableLanguages = ['en', 'si', 'ta'];
            
            if (in_array($browserLang, $availableLanguages)) {
                $language = $browserLang;
            }
        }
        
        return new self($language);
    }
    
    /**
     * Generate language selector HTML
     */
    public function generateLanguageSelector($currentPage = '') {
        $html = '<div class="language-selector">';
        $html .= '<select name="language" id="language-select" onchange="changeLanguage(this.value)">';
        
        foreach ($this->availableLanguages as $code => $name) {
            $selected = ($code === $this->currentLanguage) ? 'selected' : '';
            $html .= "<option value=\"{$code}\" {$selected}>{$name}</option>";
        }
        
        $html .= '</select>';
        $html .= '</div>';
        
        // Add JavaScript for language change
        $html .= '
        <script>
        function changeLanguage(lang) {
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set("lang", lang);
            window.location.href = currentUrl.toString();
        }
        </script>';
        
        return $html;
    }
}

// Global function for easy translation access
function __($key, $params = [], $default = null) {
    global $lang;
    
    if (!isset($lang)) {
        $lang = LanguageManager::initialize();
    }
    
    return $lang->translate($key, $params, $default);
}

// Initialize language manager if not already done
if (!isset($lang)) {
    // Check for language parameter in URL
    if (isset($_GET['lang'])) {
        $lang = new LanguageManager($_GET['lang']);
    } else {
        $lang = LanguageManager::initialize();
    }
}

?>