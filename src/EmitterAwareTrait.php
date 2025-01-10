<?php

namespace League\Event;

if (PHP_VERSION_ID < 70100) {
    trait EmitterAwareTrait {
        /**
         * The emitter instance.
         *
         * @var EmitterInterface|null
         */
        protected $emitter;

        /**
         * Set the Emitter.
         *
         * @param EmitterInterface|null $emitter
         *
         * @return $this
         */
        public function setEmitter(EmitterInterface $emitter = null) {
            $this->emitter = $emitter;

            return $this;
        }

        /**
         * Get the Emitter.
         *
         * @return EmitterInterface
         */
        public function getEmitter() {
            if (!$this->emitter) {
                $this->emitter = new Emitter();
            }

            return $this->emitter;
        }
    }
} else {
    trait EmitterAwareTrait
    {
        /**
         * The emitter instance.
         *
         * @var EmitterInterface|null
         */
        protected $emitter;

        /**
         * Set the Emitter.
         *
         * @param EmitterInterface|null $emitter
         *
         * @return $this
         */
        public function setEmitter(?EmitterInterface $emitter = null)
        {
            $this->emitter = $emitter;

            return $this;
        }

        /**
         * Get the Emitter.
         *
         * @return EmitterInterface
         */
        public function getEmitter()
        {
            if (! $this->emitter) {
                $this->emitter = new Emitter();
            }

            return $this->emitter;
        }
    }
}
