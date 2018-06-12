<?php

namespace Hardland\LaravelTable\Tables;

interface TableInterface
{
    public function getHiddenInputView();

    public function getTheadView();

    public function getTbodyView();

    public function getPaginateView();

    public function getToastMessage();

    public function buildJson();
}
