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
public class Evenement {
      private int  idEv;
    private String nomEv,localisation,dateDEv,dateFEv;
    
    

    public Evenement() {
    }

    public Evenement(int idEv, String nomEv,String dateDEv, String dateFEv,String localisation) {
        this.idEv = idEv;
        this.nomEv = nomEv;
        this.dateDEv=dateDEv;
          this.dateFEv=dateFEv;
           this.localisation = localisation;
        
    }
public Evenement( String nomEv,String dateDEv, String dateFEv,String localisation) {
       
        this.nomEv = nomEv;
        this.dateDEv=dateDEv;
          this.dateFEv=dateFEv;
           this.localisation = localisation;
        
    }
    public int getIdEv() {
        return idEv;
    }

    public void setIdEv(int idEv) {
        this.idEv = idEv;
    }

    public String getNomEv() {
        return nomEv;
    }

    public void setNomEv(String nomEv) {
        this.nomEv = nomEv;
    }

    public String getLocalisation() {
        return localisation;
    }

    public void setLocalisation(String localisation) {
        this.localisation = localisation;
    }

    public String getDateDEv() {
        return dateDEv;
    }

    public String getDateFEv() {
        return dateFEv;
    }

    public void setDateDEv(String dateDEv) {
        this.dateDEv = dateDEv;
    }

    public void setDateFEv(String dateFEv) {
        this.dateFEv = dateFEv;
    }

    @Override
    public int hashCode() {
        int hash = 7;
        return hash;
    }

    @Override
    public boolean equals(Object obj) {
        if (this == obj) {
            return true;
        }
        if (obj == null) {
            return false;
        }
        if (getClass() != obj.getClass()) {
            return false;
        }
        final Evenement other = (Evenement) obj;
        if (this.idEv != other.idEv) {
            return false;
        }
        if (!Objects.equals(this.nomEv, other.nomEv)) {
            return false;
        }
        if (!Objects.equals(this.localisation, other.localisation)) {
            return false;
        }
        if (!Objects.equals(this.dateDEv, other.dateDEv)) {
            return false;
        }
        if (!Objects.equals(this.dateFEv, other.dateFEv)) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return "Evenement{" + "idEv=" + idEv + ", nomEv=" + nomEv + ", localisation=" + localisation + ", dateDEv=" + dateDEv + ", dateFEv=" + dateFEv + '}';
    }

   
    

}