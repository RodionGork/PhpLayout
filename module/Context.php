<?php

namespace module;

class Context extends \module\sys\ProtoContext {

    protected function getAuth() {
        return new \module\auth\BasicAuth();
    }

}
