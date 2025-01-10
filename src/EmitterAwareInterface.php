<?php

namespace League\Event;

if (PHP_VERSION_ID < 70100) {
    interface EmitterAwareInterface {
        /**
         * Set the Emitter.
         *
         * @param EmitterInterface $emitter
         *
         * @return $this
         */
        public function setEmitter(EmitterInterface $emitter = null);

        /**
         * Get the Emitter.
         *
         * @return EmitterInterface
         */
        public function getEmitter();
    }
} else {
    interface EmitterAwareInterface {
        /**
         * Set the Emitter.
         *
         * @param EmitterInterface $emitter
         *
         * @return $this
         */
        public function setEmitter(?EmitterInterface $emitter = null);

        /**
         * Get the Emitter.
         *
         * @return EmitterInterface
         */
        public function getEmitter();
    }
}
