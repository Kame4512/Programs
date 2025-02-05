<?php 
class Page {
    // Page properties
    public $title;
    public $content;
    public $keywords;
    public $buttons = array();

    // Constructor to initialize default values
    public function __construct($title = "Default Title", $content = "Default Content", $keywords = "Default Keywords") {
        $this->title = $title;
        $this->content = $content;
        $this->keywords = $keywords;
    }

    // Method to display the page
    public function Display() {
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>{$this->title}</title>
            <meta name='keywords' content='{$this->keywords}' />
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                header, footer { background-color: #f2f2f2; padding: 10px; }
                nav { margin: 10px 0; }
                nav a { margin: 0 10px; text-decoration: none; color: blue; }
                .error { color: red; }
                /* Center the footer content */
                footer {
                    text-align: center;
                    font-size: 14px; /* Optional: Adjust the font size */
                }
            </style>
        </head>
        <body>
            <header><h1>{$this->title}</h1></header>
            <nav>";

        // Display buttons if there are any
        foreach ($this->buttons as $buttonText => $buttonLink) {
            echo "<a href='{$buttonLink}'>{$buttonText}</a>";
        }

        echo "</nav>
            <main>{$this->content}</main>
            <footer>Contact us at support@taskmanager.com</footer>
        </body>
        </html>";
    }
}
?>
