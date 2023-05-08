/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.entities;

/**
 *
 * @author MSI GF63
 */
import java.util.Date;

/**
 *
 * @razi sniha
 */
public class Categorie {
    private int idCat;
    private String nomCat;

    public Categorie() {
    }
  

    public Categorie(String nomCat) {
       
        this.nomCat = nomCat;
  
    }

    public Categorie(int idCat, String nomCat) {
        this.idCat = idCat;
        this.nomCat = nomCat;
    }

    public int getIdCat() {
        return idCat;
    }

    public void setIdCat(int idCat) {
        this.idCat = idCat;
    }

    public String getNomCat() {
        return nomCat;
    }

    public void setNomCat(String nomCat) {
        this.nomCat = nomCat;
    }

    
    @Override
    public String toString() {
        return "Categorie{" + "idCat=" + idCat + ", nomCat=" + nomCat + '}';
    }

   
    


    
    
}
