<?php
namespace Krypton;

class HTMLTemplateParser
{
	/*
	 * @IDEA Everything that is inside double {{var}} can be assigned with a string value
	 *
	 */
	private $HTMLTemplate, $internalCopy;

	// public:
	/**
	 *
	 * string $filename The File to use as template {{token}} to create replaceable tokens
	 * bool $bUSEREFERENCE if true, creates 2 copies of the string received from the template, let's you assign new values over and over
	 *
	 * @param string $filename        	
	 * @param bool $bUSEREFERENCE        	
	 * @throws Exception
	 *
	 */
	public function __construct(string $filename, bool $bUSE_INTERNAL_COPY = false)
	{
		if (file_exists ( $filename ))
		{
			$this->HTMLTemplate = file_get_contents ( $filename );
			if ($bUSE_INTERNAL_COPY)
			{
				$this->internalCopy = $this->HTMLTemplate;
			}
		}
		else
		{
			throw new \Exception ( "File {$filename} could not be found!" );
		}
	}

	public function assign($token, $value) // :void
	{
		$this->HTMLTemplate = preg_replace_callback ( '/{{\b' . preg_quote ( $token, '/' ) . '\b}}/', function ($match) use ($token, $value)
		{
			return str_replace ( '{{' . $token . '}}', htmlspecialchars ( $value ), $match [0] );
		}, $this->HTMLTemplate );
	}

	public function __toString(): string
	{
		return $this->build ();
	}

	public function build(bool $bHTML_OUTPUT = false): string
	{
		$this->sanitize ();
		if ($bHTML_OUTPUT)
		{
			return htmlspecialchars_decode ( $this->HTMLTemplate );
		}
		else
		{
			return $this->HTMLTemplate;
		}
	}

	public function reset()
	{
		$this->HTMLTemplate = $this->internalCopy;
	}

	// private:
	private function sanitize() // :void
	{
		$x = preg_match_all ( '/(\{\{.*?\}\})/', $this->HTMLTemplate, $matches );
		
		foreach ( $matches [1] as $match )
		{
			
			$this->HTMLTemplate = str_replace ( $match, "", $this->HTMLTemplate );
		}
	}

}