<nav>
    <ul>
        <li<?php if ($this->router->fetch_method() == 'dashboard') echo ' class="active"'; ?>>
            <a href="<?php echo site_url('admin/home') ?>">
                <i class="fas fa-tachometer-alt"></i><br>
                <?php echo $this->lang->line('ma1'); ?>
            </a>
        </li>          
        <li<?php if (($this->router->fetch_method() == 'notifications')) echo ' class="active"'; ?>>
            <a href="<?php echo site_url('admin/notifications') ?>">
                <i class="far fa-bell"></i><br>
                <?php echo $this->lang->line('ma2'); ?>
            </a>
        </li>
        <li<?php if (($this->router->fetch_method() == 'users') || ($this->router->fetch_method() == 'new_user')) echo ' class="active"'; ?>>
            <a href="<?php echo site_url('admin/users') ?>">
                <i class="fas fa-users"></i><br>
                <?php echo $this->lang->line('ma3'); ?>
            </a>
        </li>
        <li<?php if ($this->router->fetch_method() == 'admin_apps') echo ' class="active"'; ?>>
            <a href="<?php echo site_url('admin/apps') ?>">
                <i class="fas fa-rocket"></i><br>
                <?php echo $this->lang->line('apps'); ?>
            </a>
        </li>        
        <li<?php if ($this->router->fetch_method() == 'tools') echo ' class="active"'; ?>>
            <a href="<?php echo site_url('admin/tools') ?>">
                <i class="fas fa-cogs"></i><br>
                <?php echo $this->lang->line('ma4'); ?>
            </a>
        </li>
        <li<?php if ($this->router->fetch_method() == 'manage_bots') echo ' class="active"'; ?>>
            <a href="<?php echo site_url('admin/bots') ?>">
                <i class="fas fa-thumbtack"></i><br>
                <?php echo $this->lang->line('ma159'); ?>
            </a>
        </li>        
        <li<?php if (($this->router->fetch_method() == 'networks')) echo ' class="active"'; ?>>
            <a href="<?php echo site_url('admin/networks') ?>">
                <i class="far fa-share-square"></i><br>
                <?php echo $this->lang->line('ma5'); ?>
            </a>
        </li>
        <li<?php if (($this->router->fetch_method() == 'admin_plans')) echo ' class="active"'; ?>>
            <a href="<?php echo site_url('admin/plans') ?>">
                <i class="fas fa-hand-holding-usd"></i><br>
                <?php echo $this->lang->line('ma6'); ?>
            </a>
        </li>                
        <li<?php if (($this->router->fetch_method() == 'settings')) echo ' class="active"'; ?>>
            <a href="<?php echo site_url('admin/settings') ?>">
                <i class="fas fa-cog"></i><br>
                <?php echo $this->lang->line('ma7'); ?>
            </a>
        </li>
    </ul>
</nav>