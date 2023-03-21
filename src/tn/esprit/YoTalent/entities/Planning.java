/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.YoTalent.entities;
import tn.esprit.YoTalent.entities.Evenement;
import java.util.List;
import java.util.Objects;

/**

import java.util.Objects;

/**
 *
 * @author USER
 */
public class Planning   {
    
    private int idP ;
   // public  Evenement evenement;
    private String hour,nomActivite,datePL;
    private Evenement idEv ;

    public Planning() {
    }

    public Planning(int idP, String hour, String nomActivite, String datePL, Evenement idEv) {
        this.idP = idP;
        this.hour = hour;
        this.nomActivite = nomActivite;
        this.datePL = datePL;
        this.idEv = idEv;
    }

    public Planning(int idP, Evenement idEv) {
        this.idP = idP;
        this.idEv = idEv;
    }

    public Planning(String hour, String nomActivite, String datePL, Evenement idEv) {
        this.hour = hour;
        this.nomActivite = nomActivite;
        this.datePL = datePL;
        this.idEv = idEv;
    }

    public Planning(int idP, String hour, String nomActivite, String datePL) {
        this.idP = idP;
        this.hour = hour;
        this.nomActivite = nomActivite;
        this.datePL = datePL;
    }

   


    
    


    public Planning(String hour, String nomActivite, String datePL) {
        this.hour = hour;
        this.nomActivite = nomActivite;
        this.datePL = datePL;
    }

    public int getIdP() {
        return idP;
    }

    public void setIdP(int idP) {
        this.idP = idP;
    }

    public String getHour() {
        return hour;
    }

    public void setHour(String hour) {
        this.hour = hour;
    }

    public String getNomActivite() {
        return nomActivite;
    }

    public void setNomActivite(String nomActivite) {
        this.nomActivite = nomActivite;
    }

    public String getDatePL() {
        return datePL;
    }

    public void setDatePL(String datePL) {
        this.datePL = datePL;
    }

    public Evenement getIdEv() {
        return idEv;
    }

    public void setIdEv(Evenement idEv) {
        this.idEv = idEv;
    }

    @Override
    public String toString() {
        return "Planning{" + "idP=" + idP + ", hour=" + hour + ", nomActivite=" + nomActivite + ", datePL=" + datePL + ", idEv=" + idEv + '}';
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
        final Planning other = (Planning) obj;
        if (this.idP != other.idP) {
            return false;
        }
        if (!Objects.equals(this.hour, other.hour)) {
            return false;
        }
        if (!Objects.equals(this.nomActivite, other.nomActivite)) {
            return false;
        }
        if (!Objects.equals(this.datePL, other.datePL)) {
            return false;
        }
        if (!Objects.equals(this.idEv, other.idEv)) {
            return false;
        }
        return true;
    }

   
  

    
    
    
    
    
    
}