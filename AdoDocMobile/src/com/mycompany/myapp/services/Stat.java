/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.services;

/**
 *
 * @author dhia-
 */
public class Stat {
    
   private String label;
   private  int value;

    public Stat() {
    }

    public Stat(String label, int value) {
        this.label = label;
        this.value = value;
    }

    public String getLabel() {
        return label;
    }

    public int getValue() {
        return value;
    }

    public void setLabel(String label) {
        this.label = label;
    }

    public void setValue(int value) {
        this.value = value;
    }
   
   
}