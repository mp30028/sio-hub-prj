<?php
namespace siohub\app\db\events;



class DbEvent{
    public const  READ = "READ";
    public const  CREATE = "CREATE";    
    public const  UPDATE = "UPDATE";
    public const  DELETE = "DELETE";
    public const  OTHER = "OTHER";
    
    public string $id;
    public string $eventType;
    public array $data;
    
    public function __construct(string $id = "", string $eventType = self::READ, array $data = [] ){
        $this->id = $id;
        $this->eventType = $eventType;
        $this->data = $data;
    }
}

