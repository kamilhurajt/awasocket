<?php

namespace AwaSocket;

/**
 * Description of Server
 *
 * @author Kamil Hurajt <hurajtk@gmail.com>
 */
class Server implements Server\ServerInterface
{

    /**
     * Socket library
     * @var Server\AdapterInterface
     */
    protected $adapter;
    protected $host;
    protected $port;
    protected $master;

    /**
     * @var Events\ManagerInterface
     */
    protected $eventManger;

    public function __construct(Server\AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Restart server
     */
    public function restart()
    {
        $this->stop();
        sleep(1);
        $this->start();
    }

    /**
     * Start server
     * @events
     * - beforeStart($event, $server)
     * - afterStart($event, $server)
     */
    public function start()
    {
        if ($this->eventManger) {
            $this->eventManger->fire('beforeStart', $this);
        }

        $this->adapter->run();

        if ($this->eventManger) {
            $this->eventManger->fire('afterStart', $this);
        }
    }

    /**
     * Stop server
     * @events
     * - beforeStop($event, $server)
     * - afterStop($event, $server)
     */
    public function stop()
    {
        if ($this->eventManger) {
            $this->eventManger->fire('beforeStop', $this);
        }

        $this->adapter->stop();

        if ($this->eventManger) {
            $this->eventManger->fire('afterStop', $this);
        }
    }

    /**
     * Get events manager
     * @return Events\ManagerInterface Description
     */
    public function getEventManger()
    {
        return $this->eventManger;
    }

    /**
     * Set events manager
     * @param Events\ManagerInterface $manager
     */
    public function setEventManager(Events\ManagerInterface $manager)
    {
        $this->eventManger = $manager;
    }

    /**
     * Get socket library
     * @return SocketInterface
     */
    public function getSocket()
    {
        return $this->adapter;
    }

}
