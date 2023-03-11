<?php
namespace siohub\app\db\events;



class DbEvent{
    public const  READ = 1;
    public const  CREATE = 2;    
    public const  UPDATE = 3;
    public const  DELETE = 4;
    public const  OTHER = 99;
    
    public string $id;
    public int $eventType;
    public array $data;
    
    public function __construct(string $id = "", int $eventType = self::READ, array $data = [] ){
        $this->id = $id;
        $this->eventType = $eventType;
        $this->data = $data;
    }
}

