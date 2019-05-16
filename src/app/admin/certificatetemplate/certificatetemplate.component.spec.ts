import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CertificatetemplateComponent } from './certificatetemplate.component';

describe('CertificatetemplateComponent', () => {
  let component: CertificatetemplateComponent;
  let fixture: ComponentFixture<CertificatetemplateComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CertificatetemplateComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CertificatetemplateComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
