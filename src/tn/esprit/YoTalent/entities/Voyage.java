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
public class Voyage {
    private int idVoy;
  
    private String nom;

    public Voyage(int idVoy) {
        this.idVoy = idVoy;
    }

    public Voyage(int idVoy, String nom) {
        this.idVoy = idVoy;
        this.nom = nom;
    }

    public int getIdVoy() {
        return idVoy;
    }

    public void setIdVoy(int idVoy) {
        this.idVoy = idVoy;
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    @Override
    public int hashCode() {
        int hash = 7;
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
        final Voyage other = (Voyage) obj;
        if (this.idVoy != other.idVoy) {
            return false;
        }
        if (!Objects.equals(this.nom, other.nom)) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return "Voyage{" + "idVoy=" + idVoy + ", nom=" + nom + '}';
    }
    
    
}
