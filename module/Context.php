<?php

module('sys/ProtoContext');

class Context extends ProtoContext {

    protected function getAuth() {
        module('auth/BasicAuth');
        return new BasicAuth();
    }

}
