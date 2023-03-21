/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.YoTalent.entities;
import java.util.Objects;



/**
 *
 * @author USER
 */
public class Categorie {
    
private int idCat;
    private String nomCat;
  
   
   

    public Categorie(){}

    public Categorie(int idCat) {
        this.idCat = idCat;
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
        
        return String.valueOf(idCat);
    }
    @Override
    public int hashCode() {
        int hash = 5;
        return hash;
    }

    @Override
    public boolean equals(Object obj) {
        if (obj == null) {
            return false;
        }
        if (getClass() != obj.getClass()) {
            return false;
        }
        final Categorie other = (Categorie) obj;
        if (this.idCat != other.idCat) {
            return false;
        }
        if (!Objects.equals(this.nomCat, other.nomCat)) {
            return false;
        }
        return true;
    }

    
    
    
    
    
    
    
    
}



