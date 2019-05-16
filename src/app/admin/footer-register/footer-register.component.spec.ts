import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { FooterRegisterComponent } from './footer-register.component';

describe('FooterRegisterComponent', () => {
  let component: FooterRegisterComponent;
  let fixture: ComponentFixture<FooterRegisterComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ FooterRegisterComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(FooterRegisterComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
