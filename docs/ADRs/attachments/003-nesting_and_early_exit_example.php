<?php

// Wrong

class ClassWithDeepNestedMethodAndNoEarlyMethodExists
{
    public function deepNestedMethod(array $bigArrayWithContent): bool
    {
        if (count($bigArrayWithContent) > 10) {
            foreach ($bigArrayWithContent as $content) {
                if (array_key_exists('special_key', $content)) {
                    foreach ($content['special_key'] as $somethingSpecial) {
                        if ($somethingSpecial === 'special') {
                            return true;
                        }
                    }
                }
                
                if (array_key_exists('normal_key', $content)) {
                    if ($content['normal_key'] !== 'normal') {
                        return true;
                    }
                }
            }
        }
        
        return false;
    }
}

// Right

class ClassWithSmallerNestedMethodAndEarlyMethodExits
{
    public function smallerNestedMethod(array $bigArrayWithContent): bool
    {
        if (count($bigArrayWithContent) <= 10) {
            return false;
        }
        
        foreach ($bigArrayWithContent as $content) {
            if ($this->checkSpecialKey($content['special_key'] ?? null)
                || $this->checkNormalKey($content['normal_key'] ?? null)) {
                return true;
            }
        }
        
        return false;
    }
    
    
    private function checkSpecialKey(?array $specialKeyContent): bool
    {
        if ($specialKeyContent === null) {
            return false;
        }
        
        foreach ($specialKeyContent as $somethingSpecial) {
            if ($somethingSpecial === 'special') {
                return true;
            }
        }
    }
    
    
    private function checkNormalKey(?array $normalKeyContent): bool
    {
        if ($normalKeyContent === null) {
            return false;
        }
        
        return $normalKeyContent !== 'normal';
    }
}