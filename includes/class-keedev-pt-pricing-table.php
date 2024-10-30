<?php
/**
 * The Pricing Table object
 */
!defined( 'ABSPATH' ) && exit; // Exit if accessed directly.

if ( !class_exists( 'KeeDev_PT_Pricing_Table' ) ) {
    class KeeDev_PT_Pricing_Table {
        const TABLE_META_NAME = 'table';

        /** @var int|bool */
        private $id = false;

        /** @var array */
        private $_data = array();

        /** @var array */
        private $table_info = false;

        public function __construct( $pricing_table = '' ) {
            if ( is_numeric( $pricing_table ) && $pricing_table > 0 ) {
                $this->set_id( $pricing_table );
            } elseif ( $pricing_table instanceof self ) {
                $this->set_id( $pricing_table->get_id() );
            } elseif ( !empty( $pricing_table->ID ) ) {
                $this->set_id( absint( $pricing_table->ID ) );
            }
        }

        /**
         * get the id
         *
         * @return bool|int
         */
        public function get_id() {
            return $this->id;
        }

        /**
         * get property
         *
         * @param string $key
         * @param mixed  $default
         *
         * @return mixed
         */
        private function get_prop( $key, $default = false ) {
            if ( array_key_exists( $key, $this->_data ) ) {
                $value = $this->_data[ $key ];
            } else {
                $value               = metadata_exists( 'post', $this->get_id(), $key ) ? get_post_meta( $this->get_id(), $key, true ) : $default;
                $this->_data[ $key ] = $value;
            }

            return $value;
        }

        /**
         * @param int $id
         */
        public function set_id( $id ) {
            $this->id = absint( $id );
        }

        /**
         * @param string $type
         *
         * @return int
         */
        public function get_column_margin( $type = 'value' ) {
            $margin = $this->get_prop( 'column_margin', 'medium' );
            if ( 'int' === $type ) {
                $values = array(
                    'none'   => 0,
                    'small'  => 10,
                    'medium' => 20,
                    'large'  => 30,
                );
                $margin = isset( $values[ $margin ] ) ? $values[ $margin ] : 20;
            }

            return $margin;
        }

        /**
         * @return string
         */
        public function get_style() {
            return $this->get_prop( 'style', 'default' );
        }

        /**
         * @return string
         */
        public function get_active_style() {
            return $this->get_prop( 'active_style', 'none' );
        }

        /**
         * @return string
         */
        public function get_hover_effect() {
            return $this->get_prop( 'hover_effect', 'none' );
        }

        /**
         * get the table
         *
         * @return mixed
         */
        public function get_table() {
            return $this->get_prop( 'table' );
        }

        public function get_table_info() {
            if ( empty( $this->table_info ) ) {
                $table            = $this->get_table();
                $this->table_info = KeeDev_PT_Pricing_Table_Admin::validate_args( $table );
            }

            return $this->table_info;
        }

        /**
         * return false if not valid
         *
         * @return bool
         */
        public function is_valid() {
            return !empty( $this->id );
        }
    }
}