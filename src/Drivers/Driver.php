<?php

namespace FelipeMenezesDM\LaravelDatabaseDriver\Drivers;

abstract class Driver
{
    private static $instance;

    /**
     * Singleton pattern
     *
     * @return Driver
     */
    public static function getInstance() : Driver
    {
        if(self::$instance === null) {
            self::$instance = new static;
        }

        return self::$instance;
    }

    /** @Override */
    public function currentTimestamp() : string
    {
        return 'current_timestamp';
    }

    /**
     * Get filter to valid invites
     *
     * @return string
     */
    public function queryInviteEmailValid() : string
    {
        return sprintf('((invites.revoked_at is null or invites.user_id is not null) and invites.expires_at >= %s and invites.instance_id = ?)', $this->currentTimestamp());
    }

    /**
     * Get filter invite email unique
     *
     * @return string
     */
    public function queryInviteEmailUnique() : string
    {
        return 'exists (select * from users_instances where users_instances.user_id = users.id and users_instances.instance_id = ?)';
    }

    /**
     * Get query to total users from domain
     *
     * @return string
     */
    public function queryCountTotalUsers() : string
    {
        return '(select count(*) from users inner join users_domains on users_domains.user_id = users.id where users_domains.domain_id = domains.id)';
    }

    /**
     * Get query to total applications from domain
     *
     * @return string
     */
    public function queryCountTotalApplications() : string
    {
        return '(select count(*) from applications where applications.domain_id = domains.id)';
    }

    /**
     * Get query to general status column
     *
     * @param $table
     * @param $enabled
     * @param $disabled
     * @return string
     */
    public function queryGeneralStatusColumn($table, $enabled, $disabled) : string
    {
        return sprintf('(case when %s.disabled_at is null then %s else %s end)', $table, $enabled, $disabled);
    }

    /**
     * Get query to user status column
     *
     * @param $table
     * @param $disabled
     * @param $pending
     * @param $enabled
     * @return string
     */
    public function queryUserStatusColumn($table, $disabled, $pending, $enabled) : string
    {
        return sprintf('(case when users_instances.disabled_at is not null then %s when users.email_verified_at is null then %s else %s end)', $disabled, $pending, $enabled);
    }

    /**
     * Get query to invite status column
     *
     * @param $revoked
     * @param $expired
     * @param $pending
     * @param $excepted
     * @return string
     */
    public function queryInviteStatusColumn($revoked, $expired, $pending, $excepted) : string
    {
        return sprintf('(case when invites.revoked_at is not null then %s when invites.user_id is null then (case when date(%s) >= date(invites.expires_at) then %s else %s end) else %s end)', $revoked, $this->currentTimestamp(), $expired, $pending, $excepted);
    }
}
